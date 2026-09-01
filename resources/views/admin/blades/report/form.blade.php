<div class="row g-3">
    <div class="mb-3 col-12">
        <label for="title" class="form-label">Título</label>
        <input 
            type="text" 
            name="title" 
            class="form-control" 
            id="title{{ isset($report->id) ? $report->id : '' }}" 
            value="{{ isset($report) ? $report->title : '' }}" 
            placeholder="Digite seu nome"
        >
    </div>
</div>
<div class="row g-3">
    <div class="mb-3 col-12">
        <label for="description" class="form-label">link</label>
        <input 
            type="text" 
            name="link" 
            class="form-control" 
            id="description{{ isset($report->id) ? $report->id : '' }}" 
            value="{{ isset($report) ? $report->description : '' }}" 
            placeholder="Digite seu nome"
        >
    </div>
</div>

<div class="mb-3 col-12">
    <label for="path_file" class="form-label">Arquivo</label>
    <input 
        type="file" 
        name="path_file" 
        accept="application/pdf" 
        data-plugins="dropify" 
        data-default-file="{{ isset($report) && $report->path_file != '' ? url('storage/'.$report->path_file) : '' }}" 
        class="form-control"
    />
    <p class="text-muted text-center mt-2 mb-0">
        {{ __('dashboard.text_img_size') }} <b class="text-danger">3 MB</b>.
    </p>
</div>

