@extends('layouts.app')

@section('content')

@foreach($produto->fotos as $foto)
<form method="POST" action="{{ route('admin.produtos.foto.destroy', $foto) }}" id="form-foto-{{ $foto->id }}">
    @csrf @method('DELETE')
</form>
@endforeach

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-2">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width:44px;height:44px;background:#eff6ff;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-pencil" style="color:#2563EB;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-700">Editar Produto</h5>
                        <p class="text-muted small mb-0">{{ $produto->nome }}</p>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger rounded-3">
                        @foreach($errors->all() as $error)
                            <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.produtos.update', $produto) }}" enctype="multipart/form-data" id="form-produto">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <div class="mb-3">
                        <label class="form-label fw-500 small">Nome</label>
                        <input type="text" name="nome" class="form-control bg-light border-0" value="{{ old('nome', $produto->nome) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-500 small">Descrição</label>
                        <div id="editor-edit" style="height:150px;background:white;border-radius:0 0 8px 8px;">{!! old('descricao', $produto->descricao) !!}</div>
                        <input type="hidden" name="descricao" id="descricao-edit">
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label fw-500 small">Estoque</label>
                            <input type="number" name="estoque" class="form-control bg-light border-0" value="{{ old('estoque', $produto->estoque) }}" min="0" required>
                        </div>
                        <div class="col mb-3">
                            <label class="form-label fw-500 small">Valor (R$)</label>
                            <input type="number" name="valor" class="form-control bg-light border-0" value="{{ old('valor', $produto->valor) }}" step="0.01" min="0" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-500 small">Categoria</label>
                        <select name="categoria_id" class="form-select bg-light border-0">
                            <option value="">— Nenhuma —</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}" {{ old('categoria_id', $produto->categoria_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-500 small">Fornecedores <span class="text-danger">*</span></label>
                        <select name="fornecedores[]" class="form-select bg-light border-0" multiple size="4" required>
                            @foreach($fornecedores as $f)
                                <option value="{{ $f->id }}" {{ in_array($f->id, old('fornecedores', $fornecedoresSelecionados)) ? 'selected' : '' }}>
                                    {{ $f->razao_social }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Segure Ctrl para selecionar mais de um</small>
                    </div>

                    @if($produto->fotos->count() > 0)
                    <div class="mb-3">
                        <label class="form-label fw-500 small">Fotos atuais</label>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach($produto->fotos as $foto)
                            <div class="position-relative" style="width:80px;height:80px;">
                                <img src="{{ asset('storage/' . $foto->arquivo) }}"
                                     style="width:80px;height:80px;object-fit:cover;border-radius:10px;">
                                <button type="button"
                                    onclick="if(confirm('Remover esta foto?')) document.getElementById('form-foto-{{ $foto->id }}').submit();"
                                    style="position:absolute;top:-6px;right:-6px;width:20px;height:20px;border-radius:50%;background:#e11d48;border:none;color:white;font-size:0.7rem;display:flex;align-items:center;justify-content:center;padding:0;cursor:pointer;">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($produto->fotos->count() < 5)
                    <div class="mb-4">
                        <label class="form-label fw-500 small">
                            Adicionar fotos ({{ 5 - $produto->fotos->count() }} restantes) — serão redimensionadas para 800×800
                        </label>
                        <div class="p-3 rounded-3 bg-light" id="dropzone" style="border:2px dashed #cbd5e1;cursor:pointer;transition:all 0.2s;">
                            <div class="text-center text-muted py-2">
                                <i class="bi bi-cloud-arrow-up fs-3 d-block mb-1"></i>
                                <span class="small">Clique ou arraste as fotos aqui</span>
                            </div>
                            <input type="file" name="fotos[]" id="fotos-input" multiple accept="image/*" class="d-none">
                        </div>
                        <div class="d-flex gap-2 flex-wrap mt-2" id="preview-fotos"></div>
                    </div>
                    @else
                    <div class="mb-4 p-3 rounded-3" style="background:#fefce8;">
                        <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i>Limite de 5 fotos atingido. Remova uma para adicionar outra.</p>
                    </div>
                    @endif

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-verde px-4" style="border-radius:10px;">
                            <i class="bi bi-check2 me-2"></i>Atualizar
                        </button>
                        <a href="{{ route('admin.produtos.index') }}" class="btn px-4" style="background:#f1f5f9;color:#475569;border-radius:10px;">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Quill
    const quill = new Quill('#editor-edit', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['clean']
            ]
        }
    });

    document.getElementById('form-produto').addEventListener('submit', function () {
        document.getElementById('descricao-edit').value = quill.root.innerHTML;
    });

    // Dropzone
    const dropzone = document.getElementById('dropzone');
    if (!dropzone) return;

    const input = document.getElementById('fotos-input');
    const preview = document.getElementById('preview-fotos');
    const MAX_FOTOS = {{ 5 - $produto->fotos->count() }};
    let arquivosProcessados = [];

    dropzone.addEventListener('click', () => input.click());

    dropzone.addEventListener('dragover', e => {
        e.preventDefault();
        dropzone.style.borderColor = '#22C55E';
        dropzone.style.background = '#f0fdf4';
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.style.borderColor = '#cbd5e1';
        dropzone.style.background = '#f8fafc';
    });

    dropzone.addEventListener('drop', e => {
        e.preventDefault();
        dropzone.style.borderColor = '#cbd5e1';
        dropzone.style.background = '#f8fafc';
        processarArquivos(Array.from(e.dataTransfer.files));
    });

    input.addEventListener('change', () => {
        processarArquivos(Array.from(input.files));
    });

    function processarArquivos(files) {
        const disponivel = MAX_FOTOS - arquivosProcessados.length;
        files.slice(0, disponivel).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            redimensionar(file, 800, 800, blob => {
                const novo = new File([blob], file.name, { type: 'image/jpeg' });
                arquivosProcessados.push(novo);
                atualizarInput();
                adicionarPreview(novo, arquivosProcessados.length - 1);
            });
        });
    }

    function redimensionar(file, maxW, maxH, callback) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = new Image();
            img.onload = () => {
                const canvas = document.createElement('canvas');
                let w = img.width, h = img.height;
                if (w > h) { if (w > maxW) { h = Math.round(h * maxW / w); w = maxW; } }
                else { if (h > maxH) { w = Math.round(w * maxH / h); h = maxH; } }
                canvas.width = w; canvas.height = h;
                canvas.getContext('2d').drawImage(img, 0, 0, w, h);
                canvas.toBlob(callback, 'image/jpeg', 0.88);
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    function atualizarInput() {
        const dt = new DataTransfer();
        arquivosProcessados.forEach(f => dt.items.add(f));
        input.files = dt.files;
    }

    function adicionarPreview(file, index) {
        const reader = new FileReader();
        reader.onload = e => {
            const wrapper = document.createElement('div');
            wrapper.className = 'position-relative';
            wrapper.style.cssText = 'width:80px;height:80px;';
            wrapper.dataset.index = index;

            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:80px;height:80px;object-fit:cover;border-radius:10px;';

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.innerHTML = '<i class="bi bi-x"></i>';
            btn.style.cssText = 'position:absolute;top:-6px;right:-6px;width:20px;height:20px;border-radius:50%;background:#e11d48;border:none;color:white;font-size:0.7rem;display:flex;align-items:center;justify-content:center;padding:0;cursor:pointer;';
            btn.addEventListener('click', () => removerFoto(index, wrapper));

            wrapper.appendChild(img);
            wrapper.appendChild(btn);
            preview.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    }

    function removerFoto(index, wrapper) {
        arquivosProcessados.splice(index, 1);
        wrapper.remove();
        atualizarInput();
        preview.querySelectorAll('[data-index]').forEach((el, i) => { el.dataset.index = i; });
    }
});
</script>
@endsection