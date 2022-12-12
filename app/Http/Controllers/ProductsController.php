<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function __construct(){
        $access = env("ACCESS");//conexion a access de sucursal
        if(file_exists($access)){
        try{  $this->conn  = new \PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb, *.accdb)};charset=UTF-8; DBQ=".$access."; Uid=; Pwd=;");
            }catch(\PDOException $e){ die($e->getMessage()); }
        }else{ die("$access no es un origen de datos valido."); }
    }

    public function index(){
        $articulos=[];
        $proced = "SELECT CODART  FROM F_ART";
        $exec = $this->conn->prepare($proced);
        $exec -> execute();
        $fil=$exec->fetchall(\PDO::FETCH_ASSOC);
        foreach($fil as $row){
            $articulos[]="'".$row['CODART']."'";
        }
        return response()->json($articulos,200);
    }

    public function pairingProducts(Request $request){
        $fil = $request->pro;
        $delete = "DELETE FROM F_ART WHERE CODART NOT IN (".implode(",",$fil).")";
        $exec = $this->conn->prepare($delete);
        $exec -> execute();
        $delete = "DELETE FROM F_LTA WHERE ARTLTA NOT IN (".implode(",",$fil).")";
        $exec = $this->conn->prepare($delete);
        $exec -> execute();
        $delete = "DELETE FROM F_STO WHERE ARTSTO NOT IN (".implode(",",$fil).")";
        $exec = $this->conn->prepare($delete);
        $exec -> execute();

        $proced = "SELECT CODART FROM F_ART";
        $exec = $this->conn->prepare($proced);
        $exec -> execute();
        $fil=$exec->fetchall(\PDO::FETCH_ASSOC);
        $colsTab = array_keys($fil[0]);//llaves de el arreglo 
        foreach($fil as $row){
            foreach($colsTab as $col){ $row[$col] = utf8_encode($row[$col]); }
            $codigo[]="'".$row['CODART']."'";
        }

        $alm = "SELECT CODALM FROM F_ALM";
        $exec = $this->conn->prepare($alm);
        $exec -> execute();
        $rowalm=$exec->fetchall(\PDO::FETCH_ASSOC);

        $cedis = env('ACCESS_CEDIS');
        $url = $cedis."/Diller/public/api/products/missing";
        $ch = curl_init($url);//inicio de curl
        $data = json_encode(["products" => $codigo]);//se codifica el arreglo de los proveedores
        //inicio de opciones de curl
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);//se envia por metodo post
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        //fin de opciones e curl
        $exec = curl_exec($ch);//se executa el curl
        $exc = json_decode($exec,true);//se decodifican los datos decodificados
        curl_close($ch);//cirre de curl
            if($exc == null){
                return response()->json("LOS ARTICULOS ESTAN BIEN");
            }else{
                $arch = $exc['articulos'];
                foreach($arch as $pro){
                    $res[] = "articulo ".$pro['CODART']." insertado con exito";
                    $ins[] = $pro['CODART'];
                    $rows = array_values($pro);
                    $insert = "INSERT INTO F_ART (CODART,EANART,FAMART,DESART,DEEART,DETART,DLAART,EQUART,CCOART,PHAART,REFART,FTEART,PCOART,FALART,FUMART,UPPART,CANART,CAEART,UMEART,CP1ART,CP2ART,CP3ART,CP4ART,CP5ART,MPTART,UEQART) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $exec = $this->conn->prepare($insert);
                    $exec -> execute($rows);
                }

                $prec = $exc['precios'];
                foreach($prec as $prices){
                    $pri = array_values($prices);
                    $insert = "INSERT INTO F_LTA (TARLTA, ARTLTA , MARLTA , PRELTA) VALUES (?,?,?,?)";
                    $exec = $this->conn->prepare($insert);
                    $exec -> execute($pri);
                }
            
                $query = "INSERT INTO F_STO(ARTSTO, ALMSTO, MINSTO, MAXSTO, ACTSTO, DISSTO) VALUES(?,?,?,?,?,?)";
                $exec = $this->conn->prepare($query);
                foreach($rowalm as $alma){
                    $almacen = $alma['CODALM'];
                    foreach($ins as $artins){    
                        try{
                        $exec->execute([$artins, $almacen, 0, 0, 0, 0]);
                        }catch (\PDOException $e){ die($e->getMessage());}
                    }
                }

                return response()->json($res);
            }
    }

}
