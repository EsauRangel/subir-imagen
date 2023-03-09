<?php

namespace App\Http\Controllers;

use App\Models\Cati;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        try {

            $catis = DB::table("catis")

                ->join("users", "users.id", "=", "catis.usuario_id")
                ->join("cati_status", "cati_status.id", "=", "catis.status_id")
                ->join("catis_usr_adms", "catis_usr_adms.usr_adm_id", "=", "catis.usuario_asign_id", "left outer")
                ->join("cati_categorias", "cati_categorias.id", "=", "catis.categoria_id", "left outer")
                ->join("cati_prioridades", "cati_prioridades.id", "=", "catis.prioridad", "left outer")
                ->join("inv_hardware", "inv_hardware.id", "=", "catis.hardware_id", "left outer")
                ->join("cati_post", "cati_post.cati_id", "=", "catis.id", "left outer")

                ->select(
                    "catis.id",
                    "catis.img",
                    "cati_prioridades.prioridad",
                    "cati_status.status",
                    "catis.categoria_id",
                    "users.nombre",
                    "catis.descripcion",
                    "inv_hardware.etiqueta",
                    "catis.created_at",
                    "catis_usr_adms.nombre_usr",
                    "cati_categorias.categoria",
                    "catis.incidencia_id",
                    "catis.tipo_id",
                    "catis.visible",
                    "cati_post.comentario"
                )


                ->Where("cati_status.id", "=", "1")
                ->orWhere("cati_status.id", "=", "3")
                ->orWhere("cati_status.id", "=", "4")
                ->orWhere("cati_status.id", "=", "6")

                ->groupBy('catis.id')


                ->orderBy('catis.id', 'ASC')
                ->get();

            return response()->json($catis);
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();

            $response = [
                'success' => $success,
                'message' => $message

            ];

            return response()->json($response);
        }

        return response()->json($catis);
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'hardware_id' => 'required',
                'descripcion' => 'required'
            ]);

            $input = $request->all();
            $imageName = null;

            if ($image = $request->file('img')) {
                $destinationPath = 'catis/';
                $imageName = date('YmdHis')  . "."  . $image->getClientOriginalExtension();
                $image->move($destinationPath, $imageName);
                $input['img'] = 'http://192.168.10.43:8080/catis/' . $imageName;
            }



            $cati = Cati::create($input);
            $equipo = DB::table('inv_hardware')->Where('inv_hardware.id', '=', $request->hardware_id)->select('div_id')->get();
            $cati->div_equipo_id = $equipo[0]->div_id;
            $cati->save();



            $success = true;
            $message = "CATI creado satisfactoriamente";

            $mail = new CatiMailable($cati);
            Mail::to('esrangel@silostysa.com.mx')->send($mail);

            $response = [
                'success' => $success,
                'message' => $message,
                'cati' => $cati,
                'equipo' => $equipo[0]->div_id

            ];

            return response()->json($response);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMEssage()
            ]);
        }
    }


}
