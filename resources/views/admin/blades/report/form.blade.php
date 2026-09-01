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
        <label for="description" class="form-label">Link</label>
        <input 
            type="text" 
            name="description" 
            class="form-control" 
            id="description{{ isset($report->id) ? $report->id : '' }}" 
            value="{{ isset($report) ? $report->description : '' }}" 
            placeholder="Link"
        >
    </div>
</div>

<div class="mb-3 col-12">
    <div class="form-check">
        <input 
            name="active" 
            {{ isset($report->active) && $report->active == 1 ? 'checked' : '' }} 
            type="checkbox" 
            class="form-check-input" 
            id="invalidCheck{{ isset($report->id) ? $report->id : '' }}" 
        />
        <label class="form-check-label" for="invalidCheck{{ isset($report->id) ? $report->id : '' }}">
            {{ __('dashboard.active') }}?
        </label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>
