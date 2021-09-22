<?php
//cargar toda la libreria
include 'Api_google/vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS=logitechmovil-e2a4a46e4ba8.json');

$client = new Google_Client();
//tipo de credencial que vams¿os a utilizar
$client->useApplicationDefaultCredentials();
$client->setScopes(['https://www.googleapis.com/auth/drive.file']);

try {
    $service = new Google_Service_Drive($client);
    $file_path = "descarga.png";
    $file = new Google_Service_Drive_DriveFile();
    $file->setName($file_path);
    $file->setParents(array("1noRoyR3ApKWVBLMQGaTjx3ugD-ttLCR4"));
    $file->setDescription("ArchivoCargado Desde PHP");
    $file->setMimeType("image/png");

    $resultado = $service->files->create(
        $file,array(
            'data'=>file_get_contents($file_path),
            'mimeType'=> "image/png",
            'uploadType' => 'media'
        )
    );

    echo "<a href=https://drive.google.com/open?id=$resultado->id  target='_blank'>Ver el archivo</a>";

}catch (Google_Service_Exception $gs) {
    $mensaje = json_decode($gs->getMessage());
    echo $mensaje->error->message();
}catch(Exception $e){
    echo $e->getMessage();
}

?>