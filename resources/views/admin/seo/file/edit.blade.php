@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.seo.file.update',[$file->id]) }}" method="POST" autocomplete="off">
            @method('put')
            @csrf
            <div class="d-flex mb-3 pb-3 border-bottom">
                <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                    <a href="{{ route('admin.seo.file.index') }}" class="btn btn-secondary">{{ __('Hủy') }}</a>
                    @can('FileController.edit')
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                        </svg>
                        {{ __('Lưu') }}
                    </button>
                    @endif
                </div>
            </div>
            <div>
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">{{ __('Tên file') }}</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $file->name }}"
                           aria-describedby="nameHelp" required @cannot('FileController.edit') disabled @endif>
                    <div id="nameHelp" class="form-text fst-italic text-danger-emphasis">Lưu ý: {{ __('Tên danh mục') }}
                        không được dài
                        quá 255 ký tự
                    </div>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label fw-bold">{{ __('Nội dung') }}</label>
                    <textarea id="content" name="content" class="d-none @error('content') is-invalid @enderror"></textarea>
                    <div id="code-editor" class="w-100" style="height: calc(100vh - 360px)"></div>
                    @error('content')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.33.1/ace.min.js" integrity="sha512-58PBCIyyhiDe1VEw2ouZsbUaGzY5vlEXV/WgqGXssAt2sOxRr+g2AxUQ9gsCXFsB8YuTOty6T77aqNmkWCFSog==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.33.1/ext-language_tools.min.js" integrity="sha512-L1fGnwuG4x/B10Knb7+pVdprcjoUWdAxgW0KrhPpOFGMzacyfYV5E1BU1WVGO8stXVxdtp2YX5QCYXtwKxsTFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(function() {
            const langTools = ace.require("ace/ext/language_tools");
            const editor = ace.edit("code-editor", {
                useSoftTabs: true,
                fontSize: '18px',
                readOnly: {{ Auth::user()->can('FileController.edit') ? 'false' : 'true' }}
            });
            editor.setTheme("ace/theme/eclipse");
            editor.session.setMode(`ace/mode/{{ pathinfo($file->name, PATHINFO_EXTENSION) }}`);
            editor.setValue(`{!! $file->content !!}`);
            editor.setOptions({
                enableBasicAutocompletion: true,
                enableSnippets: true,
                enableLiveAutocompletion: false
            });
            const rhymeCompleter = {
                getCompletions: function (editor, session, pos, prefix, callback) {
                    if (prefix.length === 0) {
                        callback(null, []);
                        return;
                    }
                    $.ajax({
                        url:  'http://rhymebrain.com/talk?function=getRhymes&word=' + prefix,
                        type: 'GET',
                        dataType: 'jsonp',
                        CORS: true,
                        contentType: 'application/json',
                        secure: false,
                        headers: {
                            'Access-Control-Allow-Origin': '*',
                        },
                        success: function (wordList) {
                            callback(
                                null,
                                wordList.map(function (ea) {
                                    return {
                                        name: ea.word,
                                        value: ea.word,
                                        score: ea.score,
                                        meta: 'rhyme',
                                    };
                                })
                            );
                        }
                    });
                },
            };
            langTools.addCompleter(rhymeCompleter);

            const textarea = $('textarea[name="content"]');
            textarea.val(editor.getSession().getValue());
            editor.getSession().on("change", function () {
                textarea.val(editor.getSession().getValue());
            });
        });
    </script>
@endsection
