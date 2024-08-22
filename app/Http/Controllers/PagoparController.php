<?php

namespace App\Http\Controllers;

use App\Helpers\OrderHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Helpers\PagoparHelper;
use App\Models\Order;
use App\Models\Pagopar;
use Exception;

class PagoparController extends Controller
{

    private $privateKey;
    private $publicKey;
    private $orderStatus;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->privateKey   = PagoparHelper::getPrivateKey();
        $this->publicKey    = PagoparHelper::getPublicKey();
        $this->orderStatus  = false;
    }

    public function create(Request $request) {

    }

    public function store(Request $request) {
        $input = $request->all();

        if( empty($input['id']) ){
            return back()->with('message', [
                'status' => 'danger',
                'msg'    => 'Id Not Found.'
            ]);
        }

        if( empty($input['amount']) ){
            return back()->with('message', [
                'status' => 'danger',
                'msg'    => 'Amount Not Found.'
            ]);
        }

        $idOrder = $input['id'];
        $totalAmount = $input['total'];

        $token = PagoparHelper::getPaymentCreateHash($idOrder, $totalAmount, $this->privateKey);

        $data['buyer'] = PagoparHelper::getBuyer();
        $data['seller'] = PagoparHelper::getSeller();

        $array = PagoparHelper::getJSonCreateFormat($token, $idOrder, $totalAmount, $data, $this->publicKey);

        // Realizar la petición a la API de Pagopar
        $response = Http::post('https://api.pagopar.com/api/comercios/2.0/iniciar-transaccion', $array);

        if ($response->successful()) {
            $result = $response->json();

            if ($result['respuesta']) {
                $order = $result['resultado'][0];

                try {
                    // Almacenar el hash del pedido en la base de datos
                    // OrderModel::create(['hash' => $pedido['data'], 'id_pedido_comercio' => $idPedido, ...]);

                    // DB::beginTransaction();
                    // OrderModel::create([
                    //     'hash' => $order['data'],
                    //     'id_pedido_comercio' => $idOrder,
                    //     'monto_total' => $totalAmount,
                    //     'status' => 'pendiente'
                    // ]);
                    // DB::commit();

                    return response()->json([
                        'success' => true,
                        'pedido' => $order
                    ]);
                } catch( Exception $e) {

                    Log::alert($e->getMessage());

                    // DB::rollBack();

                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]);
                }

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el pedido en Pagopar.'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error en la comunicación con Pagopar.'
            ]);
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function response(Request $request)
    {
        $data = $request->json()->all();
        $result = $data['resultado'][0];

        Log::info($result);

        $payed = $result['pagado'];
        $pledgeNumber = $result['numero_comprobante_interno'];
        $hashOrder = $result['hash_pedido'];
        $token = $result['token'];

        // Generar token esperado
        $expectedToken = sha1($this->privateKey . $hashOrder);

        // Validar token
        if ($token !== $expectedToken) {
            return response()->json(['error' => 'Token inválido'], 400);
        }


        // Procesar pedido
        // Aquí deberías actualizar el estado del pedido en tu sistema
        // Ejemplo:
        // $pedido = Pedido::where('numero_pedido', $resultado['numero_pedido'])->first();
        // $pedido->estado = 'pagado';
        // $pedido->save();

        $this->orderStatus = Order::setOrderStatus($result['numero_pedido']);

        // Retornar respuesta a Pagopar
        return response()->json($data['resultado'], 200);
    }

    public function result(Request $request)
    {
        $hashOrder = $request->query('hash_pedido');

        // Generar token
        $token = PagoparHelper::getPaymentResultHash($this->privateKey);

        // Datos a enviar a la API de Pagopar
        $data = [
            'hash_pedido' => $hashOrder,
            'token' => $token,
            'token_publico' => $this->publicKey
        ];

        // Realizar la petición a la API de Pagopar
        $response = Http::post('https://api.pagopar.com/api/pedidos/1.1/traer', $data);

        if ($response->successful()) {
            $result = $response->json();

            if ($result['respuesta']) {
                $order = $result['resultado'][0];

                // save response <<
                $params = [
                    'payed' => $order->pagado,
                    'payment_method' => $order->forma_pago,
                    'payment_date' => $order->fecha_pago,
                    'amount' => $order->monto,
                    'maximum_payment_date' => $order->fecha_maxima_pago,
                    'order_number' => $order->numero_pedido,
                    'cancelled' => $order->cancelado,
                    'payment_method_identifier' => $order->forma_pago_identificador,
                    'token' => $order->token,
                    'payment_result_message' => json_encode($order->mensaje_resultado_pago),
                ];

                $pagopar = Pagopar::where('order_hash', $hashOrder)->firstOrFail();

                $pagopar->fill($params)->save();

                // Mostrar el estado del pedido al usuario
                return view('pagopar.result', ['order' => $order]);
            } else {
                return view('pagopar.error', ['message' => 'Error al obtener el estado del pedido.']);
            }
        } else {
            return view('pagopar.error', ['message' => 'Error en la comunicación con Pagopar.']);
        }
    }

    public function pagopar(Request $request)
    {
        if($request->input()) {
            Log::info(json_encode($request->input()));

            $params = $request->resultado[0];
            $order_hash = [
            'order_hash' => $params['hash_pedido']
            ];
            unset($params['hash_pedido']);
            Pagopar::updateOrCreate($order_hash, $params);

            return $request->resultado;
        }
    }
}
