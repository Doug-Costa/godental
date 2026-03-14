<?php

namespace Database\Seeders;

use App\Models\AnamnesisTemplate;
use Illuminate\Database\Seeder;

class AnamnesisTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            ['id' => 'q1', 'text' => 'Você tem algum problema de saúde que necessite de acompanhamento médico?', 'type' => 'yes_no'],
            ['id' => 'q2', 'text' => 'Está sob tratamento médico no momento? Se sim, para quê?', 'type' => 'yes_no_text'],
            ['id' => 'q3', 'text' => 'Está tomando algum medicamento? Se sim, quais?', 'type' => 'yes_no_text'],
            ['id' => 'q4', 'text' => 'Sofre de algum tipo de alergia (medicamentos, alimentos, látex, etc.)?', 'type' => 'yes_no_text'],
            ['id' => 'q5', 'text' => 'Já teve problemas ou reações com anestesia local anteriormente?', 'type' => 'yes_no_text'],
            ['id' => 'q6', 'text' => 'Sofre de problemas cardíacos (sopro, arritmia, insuficiência)?', 'type' => 'yes_no'],
            ['id' => 'q7', 'text' => 'Tem pressão alta (hipertensão)?', 'type' => 'yes_no'],
            ['id' => 'q8', 'text' => 'Você tem diabetes?', 'type' => 'yes_no'],
            ['id' => 'q9', 'text' => 'Já teve febre reumática?', 'type' => 'yes_no'],
            ['id' => 'q10', 'text' => 'Tem problemas de coagulação ou sangramento excessivo após cortes ou extrações?', 'type' => 'yes_no'],
            ['id' => 'q11', 'text' => 'Está grávida ou amamentando? (Para mulheres)', 'type' => 'yes_no'],
            ['id' => 'q12', 'text' => 'Já teve hepatite (A, B ou C), tuberculose ou outra doença infectocontagiosa?', 'type' => 'yes_no_text'],
            ['id' => 'q13', 'text' => 'Passou por alguma cirurgia ou hospitalização nos últimos 12 meses?', 'type' => 'yes_no_text'],
            ['id' => 'q14', 'text' => 'Você fuma ou consome bebidas alcoólicas com regularidade?', 'type' => 'yes_no'],
            ['id' => 'q15', 'text' => 'Qual o motivo principal da sua consulta hoje e o que mais lhe preocupa em sua saúde bucal?', 'type' => 'long_text'],
        ];

        AnamnesisTemplate::updateOrCreate(
            ['name' => 'Anamnese Odontológica Padrão'],
            [
                'description' => 'Modelo obrigatório para primeira consulta e avaliação geral.',
                'is_default' => true,
                'is_active' => true,
                'questions' => $questions,
            ]
        );
    }
}
