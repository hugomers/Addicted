<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgentsController extends Controller
{
    public function __construct(){
        $access = env("ACCESS");//conexion a access de sucursal
        if(file_exists($access)){
        try{  $this->conn  = new \PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb, *.accdb)};charset=UTF-8; DBQ=".$access."; Uid=; Pwd=;");
            }catch(\PDOException $e){ die($e->getMessage()); }
        }else{ die("$access no es un origen de datos valido."); }
    }

    public function replyAgents(Request $request){
        $depen = [];
        $agen = [];
        $agentes = $request->agentes;
        foreach($agentes as $agente){
            $delagen = "DELETE FROM F_AGE WHERE CODAGE = ?";
            $exec = $this->conn->prepare($delagen);
            $exec -> execute([$agente['CODAGE']]);
            $prepare = [
                $agente['CODAGE'],
                $agente['TEMAGE'],
                $agente['ZONAGE'],
                $agente['IMPAGE'],
                $agente['COMAGE'],
                $agente['TCOAGE'],
                $agente['IVAAGE'],
                $agente['IRPAGE'],
                $agente['PIRAGE'],
                $agente['FALAGE'],
                $agente['FAXAGE'],
                $agente['EMAAGE'],
                $agente['WEBAGE'],
                $agente['PAIAGE'],
                $agente['PCOAGE'],
                $agente['TEPAGE'],
                $agente['CLAAGE'],
                $agente['DNIAGE'],
                $agente['RUTAGE'],
                $agente['CUWAGE'],
                $agente['CAWAGE'],
                $agente['SUWAGE'],
                $agente['MEWAGE'],
                $agente['CPOAGE'],
                $agente['PROAGE'],
                $agente['ENTAGE'],
                $agente['OFIAGE'],
                $agente['DCOAGE'],
                $agente['CUEAGE'],
                $agente['BANAGE'],
                $agente['LISAGE'],
                $agente['CONAGE'],
                $agente['DOMAGE'],
                $agente['NOMAGE'],
                $agente['NOCAGE'],
                $agente['MEMAGE'],
                $agente['OBSAGE'],
                $agente['FORAGE'],
                $agente['LFOAGE'],
                $agente['FFOAGE'],
                $agente['OFOAGE'],
                $agente['UREAGE'],
                $agente['CURAGE'],
                $agente['URLAGE'],
                $agente['CATAGE'],
                $agente['FCCAGE'],
                $agente['FFCAGE'],
                $agente['PUNAGE'],
                $agente['CVEAGE'],
                $agente['CREAGE'],
                $agente['PURAGE'],
                $agente['JEQAGE'],
                $agente['CSAAGE'],
                $agente['AGJAGE'],
                $agente['DMWAGE'],
                $agente['FOTAGE'],
                $agente['POBAGE'],
                $agente['CTPAGE']
            ];
            $inser = "INSERT INTO F_AGE VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $exec = $this->conn->prepare($inser);
            $exec -> execute($prepare);
            $agen[]="El agente ".$agente['CODAGE']." ".$agente['NOMAGE']." se inserto correctamente";
        }
        
    

        $dependientes = $request->dependientes;
        foreach ($dependientes as $dependiente){
            $deldep = "DELETE FROM T_DEP WHERE CODDEP = ?";
            $exec = $this->conn->prepare($deldep);
            $exec -> execute([$dependiente['CODDEP']]);
            $depre = [
                $dependiente['CODDEP'],
                $dependiente['NOMDEP'],
                $dependiente['PERDEP'],
                $dependiente['IMADEP'],
                $dependiente['CLADEP'],
                $dependiente['CCLDEP'],
                $dependiente['ESTDEP'],
                $dependiente['AGEDEP'],
                $dependiente['IDIDEP']
            ];
            $insertdep = "INSERT INTO T_DEP VALUES (?,?,?,?,?,?,?,?,?)";
            $exec = $this->conn->prepare($insertdep);
            $exec -> execute($depre);
            $depen[]="El dependiente ".$dependiente['CODDEP']." ".$dependiente['NOMDEP']." se inserto correctamente";

        }

        

        $res = [
            "dependientes"=>$depen,
            "agentes"=>$agen
        ];

        return response()->json($res);
    }
}
