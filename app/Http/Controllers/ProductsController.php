<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $proced = "SELECT COUNT(*) as PRODUCTOS FROM F_ART";
        $exec = $this->conn->prepare($proced);
        $exec -> execute();
        $fil=$exec->fetch(\PDO::FETCH_ASSOC);
        $products = intval($fil['PRODUCTOS']);
        return response()->json($products,200);
    }
}
