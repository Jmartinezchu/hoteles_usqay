<?php

class Api extends Controllers
{

    public function __construct()
    {
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }
        parent::__construct();
    }

    
    public function getDni()
    {
        $token = 'apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';
        $dni = "";
        if (isset($_GET['dni']))
            $dni = $_GET['dni'];

        // Iniciar llamada a API
        $curl = curl_init();

        // Buscar dni
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.apis.net.pe/v1/dni?numero=' . $dni,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 2,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Referer: https://apis.net.pe/consulta-dni-api',
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // Datos listos para usar
        $persona = json_decode($response);
        echo json_encode($persona);
    }

    public function getRUC()
    { // Datos
        $token = 'apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';
        $ruc = "";
        if (isset($_GET['ruc']))
            $ruc = $_GET['ruc'];


        // Iniciar llamada a API
        $curl = curl_init();

        // Buscar ruc sunat
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.apis.net.pe/v1/ruc?numero=' . $ruc,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Referer: http://apis.net.pe/api-ruc',
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $empresa = json_decode($response);
        echo json_encode($empresa);
    }

    //EXTRAER UN Api
    public function getTipoCambio()
    {
        $token = 'apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';
        $fecha = "";
        if (isset($_GET['fecha']))
            $fecha = $_GET['fecha'];

        // Iniciar llamada a API
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.apis.net.pe/v1/tipo-cambio-sunat?fecha=' . $fecha,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 2,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Referer: https://apis.net.pe/tipo-de-cambio-sunat-api',
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // Datos listos para usar
        $tipoCambioSunat = json_decode($response);
        var_dump($tipoCambioSunat);
    }
    public function getSelectApiCMb()
    {
        $htmlOptions = "";
        $arrData = $this->model->selectApi();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                echo $arrData[0]['idtipo_usuario'];
                $htmlOptions .= '<option value="' . $arrData[$i]['idApi'] . '">' . $arrData[$i]['nombre_tipousuario'] . '</option>';
            }
        }
        echo $htmlOptions;
        die();
    }

 
}
