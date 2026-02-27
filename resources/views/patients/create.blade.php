@extends('facelift2.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center mb-4">
                    <a href="{{ route('patients.index') }}" class="btn btn-light rounded-circle me-3"
                        style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="fw-bold mb-0" style="color: #4f4f4f;">Novo Paciente</h1>
                        <p class="text-secondary mb-0">Cadastro rápido no prontuário GoClinic</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('patients.store') }}" method="POST">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Nome Completo</label>
                                    <input type="text" name="full_name"
                                        class="form-control form-control-lg @error('full_name') is-invalid @enderror"
                                        placeholder="Ex: Ana Maria Silva" value="{{ old('full_name') }}" required
                                        style="border-radius: 12px; background-color: #F8F9FA; border-color: #eee;">
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Telefone / WhatsApp</label>
                                    <input type="text" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="Ex: (44) 99999-9999" value="{{ old('phone') }}"
                                        style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">E-mail (Opcional)</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="contato@exemplo.com" value="{{ old('email') }}"
                                        style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Gênero</label>
                                    <select name="gender" class="form-select @error('gender') is-invalid @enderror"
                                        style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;">
                                        <option value="">Selecione...</option>
                                        <option value="Masculino" {{ old('gender') == 'Masculino' ? 'selected' : '' }}>
                                            Masculino</option>
                                        <option value="Feminino" {{ old('gender') == 'Feminino' ? 'selected' : '' }}>Feminino
                                        </option>
                                        <option value="Outro" {{ old('gender') == 'Outro' ? 'selected' : '' }}>Outro</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Como nos conheceu?</label>
                                    <select name="discovery_source"
                                        class="form-select @error('discovery_source') is-invalid @enderror"
                                        style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;">
                                        <option value="">Selecione...</option>
                                        <option value="Instagram" {{ old('discovery_source') == 'Instagram' ? 'selected' : '' }}>Instagram</option>
                                        <option value="Facebook" {{ old('discovery_source') == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                                        <option value="Google" {{ old('discovery_source') == 'Google' ? 'selected' : '' }}>
                                            Google</option>
                                        <option value="Indicação" {{ old('discovery_source') == 'Indicação' ? 'selected' : '' }}>Indicação</option>
                                        <option value="Outros" {{ old('discovery_source') == 'Outros' ? 'selected' : '' }}>
                                            Outros</option>
                                    </select>
                                    @error('discovery_source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Data de Registro</label>
                                    <input type="date" name="registration_date"
                                        class="form-control @error('registration_date') is-invalid @enderror"
                                        value="{{ old('registration_date', date('Y-m-d')) }}"
                                        style="border-radius: 10px; background-color: #F8F9FA; border-color: #eee;">
                                    @error('registration_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Observações Clínicas / Alergias</label>
                                    <textarea name="clinical_observations" rows="4"
                                        class="form-control @error('clinical_observations') is-invalid @enderror"
                                        placeholder="Notas rápidas sobre o paciente..."
                                        style="border-radius: 12px; background-color: #F8F9FA; border-color: #eee;">{{ old('clinical_observations') }}</textarea>
                                    @error('clinical_observations')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 pt-3">
                                    <button type="submit" class="btn text-white px-5 py-3 fw-bold w-100 w-md-auto"
                                        style="background-color: #CA1D53; border-radius: 12px;">
                                        Cadastrar Paciente
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection