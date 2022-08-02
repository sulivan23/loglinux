<?php 

error_reporting(0);

class ErrorLog{

    public $logfile, $type, $secondType, $firstType, $output;

    public function __construct($logFile, $firstType, $type, $secondType, $output)
    {
        $this->logFile = file_get_contents($logFile);
        $this->type = $type;
        $this->secondType = $secondType;
        $this->firstType = $firstType;
        $this->output = $output;
    }

    public function errorConversion() 
    {
        $error = explode("\n", $this->logFile);
        $error = array_filter($error);
        $error = array_map('trim', $error);
        $error = array_map('strtolower', $error);
        $error = array_unique($error);
        $error = array_values($error);
        $array = [
            'data' => $error
        ];
        if($this->type == "json") {
            $data = json_encode($array,JSON_PRETTY_PRINT);   
        }
        else if($this->type == "text" || $this->type == null || $this->firstType == "-o"){
            $data =  $this->logFile;
        }

        if($this->secondType == "-o" || $this->firstType == "-o"){
            $output = $this->output;
            if($output == null){
                $output = $this->type;
            }
            $file = fopen($output,"w");
            if(fwrite($file, $data) == false){
                $data = 'Gagal save output file!';
            }
        }

        return $data;
    }

}

$logFile = isset($argv[1]) == true ? $argv[1] : null;
$firstFlag = isset($argv[2]) == true ? $argv[2] : null;
$outputType = isset($argv[3]) == true ? $argv[3] : null;
$secondFlag = isset($argv[4]) == true ? $argv[4] : null;
$outputFile = isset($argv[5]) == true ? $argv[5] : null;

if($logFile != null){
    if(file_exists($logFile) && ($firstFlag == "-t" || $firstFlag == null || $firstFlag == "-o")){ //if log exists
        $errorLog = new ErrorLog($logFile, $firstFlag, $outputType, $secondFlag, $outputFile);
        echo $errorLog->errorConversion();
    }else{
        if($logFile == "-h") {
            echo "Petunjuk penggunaan : ";
            echo "\n";
            echo "1. Untuk print output json dapat menggunakan perintah php Loglinux.php /var/log/apache2/error.log -t json";
            echo "\n2. Untuk print output dengan plain text dapat menggunakan perintah php Loglinux.php /var/log/apache2/error.log -t text atau tanpa -t text";
            echo "\n3. Dan untuk save output ke file dapat menggunakan perintah php Loglinux.php /var/log/apache2/error.log -t json -o output.txt";
        }else{
            echo "Flag atau log file tidak ditemukan";
        }
    }
}