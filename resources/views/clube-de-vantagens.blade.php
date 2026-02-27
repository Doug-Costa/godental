@extends('facelift2.master')

@section('content')
    <style>
        /* Estilos específicos para o Clube de Vantagens */
        .clube-vantagens {
            font-family: 'Poppins', sans-serif;
            background-color: #fcfcfc;
            margin-top: 100px;
            padding-bottom: 60px;
        }

        .hero-clube {
            background: #f0f4f8;
            border-radius: 30px;
            padding: 40px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .hero-content {
            max-width: 50%;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #333;
            margin-bottom: 15px;
        }

        .hero-content p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 25px;
        }

        .badge-exclusivo {
            display: inline-flex;
            align-items: center;
            background: #fff;
            padding: 8px 20px;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            font-weight: 600;
            font-size: 0.9rem;
            color: #555;
        }

        .badge-exclusivo i {
            margin-right: 10px;
            color: #333;
        }

        .hero-image img {
            max-width: 450px;
            height: auto;
        }

        /* Cards de Categorias */
        .category-card {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #eee;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .category-icon {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .category-icon img {
            max-width: 100%;
            height: auto;
        }

        .category-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .category-card p {
            font-size: 0.9rem;
            color: #777;
            line-height: 1.5;
        }

        .tag-off {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #89c4b9;
            color: #fff;
            padding: 4px 12px;
            border-radius: 5px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Parceiros */
        .section-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #444;
            margin: 50px 0 25px;
            text-align: center;
        }

        .partners-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .partner-logo {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 15px;
            padding: 15px;
            width: 180px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: filter 0.3s;
        }

        .partner-logo img {
            max-width: 120px;
            max-height: 50px;
            filter: grayscale(1);
            opacity: 0.7;
        }

        .partner-logo:hover img {
            filter: grayscale(0);
            opacity: 1;
        }

        /* Como funciona */
        .how-it-works {
            background: #fff;
            border-radius: 25px;
            padding: 30px;
            margin-top: 50px;
            border: 1px solid #eee;
        }

        .step-item {
            display: flex;
            align-items: center;
            padding: 20px;
        }

        .step-number {
            width: 45px;
            height: 45px;
            background: #ececec;
            color: #999;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.2rem;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .step-content h4 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 2px;
        }

        .step-content p {
            font-size: 0.85rem;
            color: #888;
            margin: 0;
        }

        @media (max-width: 768px) {
            .hero-clube {
                flex-direction: column;
                text-align: center;
                padding: 30px 20px;
            }

            .hero-content {
                max-width: 100%;
                margin-bottom: 30px;
            }

            .hero-image img {
                max-width: 100%;
            }
        }
    </style>

    <div class="clube-vantagens">
        <div class="container">

            <!-- Hero Section -->
            <div class="hero-clube shadow-sm">
                <div class="hero-content">
                    <h1>Clube de Vantagens DentalGO</h1>
                    <p>Benefícios exclusivos para assinantes: livros, cursos, congressos e parceiros selecionados.</p>
                    <div class="badge-exclusivo">
                        <i class="fas fa-briefcase"></i> Exclusivo para assinantes <i class="fas fa-graduation-cap"
                            style="margin-left: 10px;"></i>
                    </div>
                </div>
                <div class="hero-image d-none d-md-block">
                    <!-- Usei uma imagem que parece se aproximar do mockup, ajuste o asset se necessário -->
                    <img src="{{ asset('imagens/Facelift/note.png') }}" alt="Ilustração Clube de Vantagens">
                </div>
            </div>

            <!-- Categorias Grid -->
            <div class="row g-4">
                <!-- Livros e Revistas -->
                <div class="col-6 col-md-3">
                    <div class="category-card position-relative">
                        <div class="tag-off">Até 30% OFF</div>
                        <div class="category-icon">
                            <img src="{{ asset('imagens/Book-Icon.png') }}" alt="Livros e Revistas">
                        </div>
                        <h3>Livros e Revistas</h3>
                        <p>Descontos exclusivos em publicações DentalPress e parceiros editoriais.</p>
                    </div>
                </div>

                <!-- Cursos e Atualizações -->
                <div class="col-6 col-md-3">
                    <div class="category-card">
                        <div class="category-icon">
                            <img src="{{ asset('imagens/icon1.jpg') }}" alt="Cursos">
                        </div>
                        <h3>Cursos e Atualizações</h3>
                        <p>Condições especiais em cursos, imersões e conteúdos educacionais.</p>
                    </div>
                </div>

                <!-- Congressos e Eventos -->
                <div class="col-6 col-md-3">
                    <div class="category-card">
                        <div class="category-icon">
                            <img src="{{ asset('imagens/icon2.jpg') }}" alt="Congressos">
                        </div>
                        <h3>Congressos e Eventos</h3>
                        <p>Descontos exclusivos em congressos e eventos oficiais DentalPress.</p>
                    </div>
                </div>

                <!-- Parceiros Selecionados -->
                <div class="col-6 col-md-3">
                    <div class="category-card">
                        <div class="category-icon">
                            <img src="{{ asset('imagens/icon3.jpg') }}" alt="Parceiros">
                        </div>
                        <h3>Parceiros Selecionados</h3>
                        <p>Benefícios em materiais, softwares e serviços para o dia a dia da clínica.</p>
                    </div>
                </div>
            </div>

            <!-- Parceiros Logotipos -->
            <h2 class="section-title">Parceiros com benefícios ativos</h2>
            <div class="partners-grid">
                <div class="partner-logo shadow-sm"><img src="{{ asset('facelift2/img/surya.png') }}" alt="Surya Dental">
                </div>
                <div class="partner-logo shadow-sm"><img src="{{ asset('facelift2/img/clinicorp.png') }}" alt="Clinicorp">
                </div>
                <div class="partner-logo shadow-sm"><img src="{{ asset('facelift2/img/doctorsa.png') }}" alt="Doctor SA">
                </div>
                <div class="partner-logo shadow-sm"><img src="{{ asset('facelift2/img/dvi.png') }}" alt="DVI"></div>
                <div class="partner-logo shadow-sm"><img src="{{ asset('facelift2/img/orthoaligner.png') }}"
                        alt="OrthoAligners"></div>
            </div>

            <!-- Como Funciona -->
            <h2 class="section-title">Como funciona</h2>
            <div class="how-it-works shadow-sm">
                <div class="row">
                    <div class="col-md-4">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h4>Seja assinante DentalGO</h4>
                                <p>Tenha uma assinatura ativa em qualquer plano.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h4>Escolha o benefício</h4>
                                <p>Navegue pelas categorias e escolha o que deseja.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h4>Utilize o cupom ou condição</h4>
                                <p>Siga as instruções para aplicar o desconto.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection