<?php
$tipoTopo = 'topoPreto';
?>
@extends('layouts.master')

@section('content')
<div class="container">
        <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            color: #333;

        }
        h1, h2 {
            color: #2c3e50;
        }
        h1 {
            text-align: center;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        li {
            margin-bottom: 10px;
        }
        strong {
            color: #34495e;
        }
        .section {
            background-color: #f9f9f9;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
<h1 style="margin-top: 100px;">Prazo de Entrega</h1>

<div class="section">
    <h2>ENTENDA OS PRAZOS DE ENTREGA</h2>
    <p>Os produtos comprados na Dental Press Store serão enviados pelos Correios. A partir da aprovação de seu pedido, entregaremos o produto com base na região da entrega e no serviço de postagem contratado (PAC ou Sedex)</p>
</div>

<div class="section">
    <h2>Importante:</h2>
    <p>O prazo para aprovação da compra varia de acordo com a forma de pagamento:</p>
    <ul>
        <li>– Em até 2 (dois) dias úteis para compras com cartão, de acordo com o horário em que o pedido foi feito.</li>
        <li>– Em até 3 (três) dias úteis para compras com boleto bancário (a partir do pagamento do documento). Este prazo é variável conforme o aviso de pagamento a ser emitido pelo banco recebedor</li>
    </ul>
    <p>Os prazos de entrega são contabilizados a partir do envio do pedido, contados em dias úteis.</p>
</div>

<div class="section">
    <h2>Atenção:</h2>
    <p>Aos compradores que selecionárem a opção retirada no loja, terão que estar com a cópia do pedido impresso para efetuarem a retirada e apresentar na expedição da Dental Press, localizada na Avenida Luiz Teixeira Mendes, 2712, Maringá, Paraná. Não serão entregues produtos e livros em standes ou eventos externos em que a Dental Press esteja participando.</p>
</div>
