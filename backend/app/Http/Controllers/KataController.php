<?php

namespace App\Http\Controllers;

use App\Models\Kata;
use Sastrawi\Stemmer\Stemmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Support\Facades\Validator as Validator;

class KataController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function cekKata(Request $request){

        $validator = Validator::make($request->all(), [
            'kalimat' => 'required',
        ]);

        if ($validator->fails()) {
            $data = response()->json($validator->errors()->toJson(), 400);
            return $data;
        }

        $starttime = microtime(true);
		function multiexplode($delimiters, $string)
		{
			$ready = str_replace($delimiters, $delimiters[0], $string);
			$launch = explode($delimiters[0], $ready);
			return  $launch;
		}

		function clean($string)
		{
			$delimiter = array(' ', '.', ',', '"', "'", '-
                            ', '/', '{', '}', '+', '_', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '
                            ?', '>', '<', '[', ']', '|', '`', '~', ';', ':', '=', '\n', '\r', '\t', '\\');
			$value = str_replace($delimiter, "", $string);
			return $value;
		}

			$textOri = $request->input('kalimat');

			//Case Folding
			$text = strtolower($textOri);
			$totalKata = str_word_count($text);
			$totalKarakter = strlen($text);
			$salah = 0;

			$flag = 0;
			
			$output = '';

			//Tokenizing
			$token = multiexplode(array(" ", "\n"), $text);
			$tokenOri = multiexplode(array(" ", "\n"), $textOri);
			$totalArrayText = count($token); // echo $tokenizedText[0]; ini contoh

			//Stemming
			$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
			$stemmer  = $stemmerFactory->createStemmer();
			//Stemming tiap kata
			for ($a = 0; $a < $totalArrayText; $a++) {
				$stemmedWord[$a] = $stemmer->stem($token[$a]);
			}

			$dataDBS = DB::table('tb_katadasar')->select('katadasar')->orderBy('katadasar')->get();
			$dataDB = $dataDBS->map(function ($obj) {
				return (Array) $obj;
			})->toArray();

			foreach ($stemmedWord as $key => $v) {
				$casefolding = strtolower($v);
				$prs = clean($casefolding);

				if (preg_match('~[0-9]+~', $prs)) {
					$flag = 1;
				} else {
					foreach ($dataDB as $word => $kt) {
						$lev = levenshtein($prs, $kt['katadasar']);
						if ($lev == 0) {
							$flag = 1;
							break;
						}
						$data[$kt['katadasar']] = $lev;
					}
				}
				
				$cekTandaBaca = substr($token[$key], strlen($token[$key]) - 1, 1) == '.' ? true : false;

				if ($flag == 1) {
					if($key == 0){
						$output .= '<span>' . ucwords($token[$key]) . '</span> ';
					}else{
						$output .= '<span> ' . $tokenOri[$key] . '</span> ';
					}
				} else {
					$salah++;
					asort($data);
					$short = reset($data);
					$option = '';
					$option .= "<option>".$v."</option>";
					foreach ($data as $key => $value) {
						if ($value == $short) {
							$option .= "<option>".$key."</option>";
						}
					}
					$output .= "<select class='spell'>".$option."</select>";
				}
				$flag = 0;
			}

			$kata = $output;
			$endtime = microtime(true);
			$estimasi = $endtime - $starttime;

            return response()->json([
                'message' => 'success',
                'estimasi' => $estimasi,
                'totalKata' => $totalKata,
                'totalKarakter' => $totalKarakter,
                'totalSalah' => $salah,
                'teksOri' => $textOri,
                'pembenaran' => $kata
            ], 201);
    }
}
