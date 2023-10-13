<?php

namespace App\Controllers;
use App\Libraries\Ciqrcode;
use Kenjis\CI3Compatible\Core\CI_Input;

use function bin2hex;
use function file_exists;
use function mkdir;

class Home extends BaseController
{

    public function index(): string
    {
    //    return $this->get_sample_code();
        return view('welcome_message');
        // $data = "noad.com";
        // $qr   = $this->generate_qrcode($data);
        // return "'".$qr['content']."'Url / Path: '".$qr['file']."'";
    }

    function generate_qrcode($data)
    {
        /* Load QR Code Library */
        // $this->load->library('ciqrcode');
        // Load the custom library
        $ciqrcode = new Ciqrcode();

        /* Data */
        $hex_data   = bin2hex($data);
        $save_name  = $hex_data . '.png';

        /* QR Code File Directory Initialize */
        $dir = 'assets/media/qrcode/';
        if (! file_exists($dir)) {
            mkdir($dir, 0775, true);
        }

        /* QR Configuration  */
        $config['cacheable']    = true;
        $config['imagedir']     = $dir;
        $config['quality']      = true;
        $config['size']         = '1024';
        $config['black']        = [255, 255, 255];
        $config['white']        = [255, 255, 255];
        $ciqrcode->initialize($config);

        /* QR Data  */
        $params['data']     = $data;
        $params['level']    = 'L';
        $params['size']     = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $save_name;

        $ciqrcode->generate($params);

        /* Return Data */
        return [
            'content' => $data,
            'file'    => $dir . $save_name,
        ];
    }

    function get_sample_code()
    {
        /* Generate QR Code */
        $data = "0273599253";
        $qr   = $this->generate_qrcode($data);
        return "'".$qr['content']."'Url / Path: '".$qr['file']."'";
    }
}
