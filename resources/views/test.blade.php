<div class="{{ $$debugId['debug_id'] }} uxmal-debug px-2 bg-light-subtle rounded-2 position-absolute top-0 end-0">
    <span class="uxmal-debug-info opacity-50">{{ $$debugId['file'] }}:{{ $$debugId['line'] }} |</span>
    <span class="uxmal-debug-url">
            <a href="idea://open?file={{$$debugId['file']}}&line={{$$debugId['line']}}">
                Editar
            </a>
        </span>
</div>