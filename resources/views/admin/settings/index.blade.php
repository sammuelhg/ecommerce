@extends('layouts.admin')

@section('title', 'Configurações da Loja')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">


                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Identidade Visual -->
                        <h5 class="mb-4 text-primary border-bottom pb-2">Identidade Visual</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Logo da Loja</label>
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    @if(isset($settings['store_logo']))
                                        <div class="border p-2 rounded bg-light">
                                            <img src="{{ $settings['store_logo'] }}" alt="Logo Atual" style="height: 60px;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control bg-white" name="store_logo" accept="image/*">
                                </div>
                                <div class="form-text">Recomendado: PNG transparente, altura min. 90px.</div>
                            </div>
                        </div>

                        <!-- Cores do Tema -->
                        <h5 class="mb-4 text-primary border-bottom pb-2 mt-5">Cores do Tema (Bootstrap Custom)</h5>
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cor Primária (Primary)</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color bg-white" name="color_primary" value="{{ $settings['color_primary'] ?? '#0d6efd' }}" title="Escolher cor">
                                    <input type="text" class="form-control bg-white" value="{{ $settings['color_primary'] ?? '#0d6efd' }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cor Secundária (Secondary)</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color bg-white" name="color_secondary" value="{{ $settings['color_secondary'] ?? '#6c757d' }}" title="Escolher cor">
                                    <input type="text" class="form-control bg-white" value="{{ $settings['color_secondary'] ?? '#6c757d' }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cor de Destaque (Accent)</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color bg-white" name="color_accent" value="{{ $settings['color_accent'] ?? '#ffc107' }}" title="Escolher cor">
                                    <input type="text" class="form-control bg-white" value="{{ $settings['color_accent'] ?? '#ffc107' }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cor de Fundo (Background)</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color bg-white" name="color_background" value="{{ $settings['color_background'] ?? '#f8f9fa' }}" title="Escolher cor">
                                    <input type="text" class="form-control bg-white" value="{{ $settings['color_background'] ?? '#f8f9fa' }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Informações da Loja -->
                        <h5 class="mb-4 text-primary border-bottom pb-2 mt-5">Informações da Loja</h5>
                        <div class="row mb-4">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Endereço Completo</label>
                                <textarea class="form-control bg-white" name="store_address" rows="3">{{ $settings['store_address'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">CNPJ</label>
                                <input type="text" class="form-control bg-white" name="store_cnpj" value="{{ $settings['store_cnpj'] ?? '' }}" placeholder="00.000.000/0000-00">
                            </div>
                        </div>

                        <!-- Certificados de Segurança -->
                        <h5 class="mb-4 text-primary border-bottom pb-2 mt-5">Certificados de Segurança</h5>
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Adicionar Certificados (Imagens)</label>
                                <input type="file" class="form-control bg-white" name="security_certificates[]" multiple accept="image/*">
                            </div>
                            
                            @if(count($certificates) > 0)
                                <div class="col-md-12 mt-3">
                                    <label class="form-label">Certificados Ativos:</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        @foreach($certificates as $cert)
                                            <div class="position-relative border p-2 rounded bg-white">
                                                <img src="{{ $cert }}" style="height: 50px; width: auto;">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle rounded-circle p-0 d-flex align-items-center justify-content-center" 
                                                        style="width: 20px; height: 20px;"
                                                        onclick="removeCertificate('{{ $cert }}')">
                                                    &times;
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="bi bi-save me-2"></i> Salvar Configurações
                            </button>
                        </div>
                    </form>
                    
                    <!-- Hidden Form for Removal -->
                    <form id="remove-cert-form" action="{{ route('admin.settings.remove-certificate') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="path" id="remove-cert-path">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function removeCertificate(path) {
        if(confirm('Tem certeza que deseja remover este certificado?')) {
            document.getElementById('remove-cert-path').value = path;
            document.getElementById('remove-cert-form').submit();
        }
    }
</script>
@endpush
@endsection
