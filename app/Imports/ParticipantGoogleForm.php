<?php

namespace App\Imports;

use App\Models\Participant;
use finfo;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Symfony\Component\Console\Output\ConsoleOutput;

class ParticipantGoogleForm implements ToModel, WithStartRow, WithValidation, SkipsOnFailure
{
    public function __construct(
        private $output = new ConsoleOutput()
    )
    {
        
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->output->writeln("<info>Menyiapkan Data: $row[1]</info>");

        $context = stream_context_create(
            array(
                "http" => array(
                    "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/109.0"
                )
            )
        );
        
        $filename = 'peserta/import_' . Str::random(15);
        $link = preg_replace("/^(https:\/\/drive\.google\.com\/open\?id=)(.*)/", "https://docs.google.com/uc?export=download&id=$2", $row[6]);   
        file_put_contents(Storage::path($filename), file_get_contents($link, false, $context));
        $headers = implode("\n", $http_response_header);
        if (preg_match_all("/filename[^;=\n]*=(?:(\\?['\"])(.*?)\1|(?:[^\s]+'.*?')?([^;\n]*))/mi", $headers, $matches)) {
            $new_filename = "$filename." . pathinfo($matches[3][1], PATHINFO_EXTENSION);
            Storage::move($filename, $new_filename);
        }


        return new Participant([
            'name' => strtoupper($row[1]),
            'banom' => strtolower($row[2]),
            'as' => strtolower($row[4]),
            'phone' => $this->filterPhone($row[5]),
            'delegasi' => preg_replace("/^(Desa )/", '', $row[3]),
            'delegasi_type' => 'pr',
            'photo' => $new_filename
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    private function filterPhone($data)
    {
        return preg_replace("/^(62|0)/", '', preg_replace("/[^\d]/", '', $data));
    }

    public function rules(): array
    {
        return [
            5 => function($attribute, $value, $onFailure) {
                $phone = $this->filterPhone($value);

                if( Participant::where('phone', $phone)->count() > 0 )
                {
                    $onFailure("Nomor telepon sudah terdaftar. (0$phone)");
                }
            }
        ];
    }

    public function onFailure(\Maatwebsite\Excel\Validators\Failure ...$failures)
    {
        foreach($failures as $failure)
        {
            $this->output->writeln("<error>" . implode(', ', $failure->errors()) . "</error>");
        }
    }
}
