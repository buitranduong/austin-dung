@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <x-admin.category.form :categories="$categories">
            <x-slot:before>
                <div class="d-flex mb-3 pb-3 border-bottom">
                    <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                        <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">{{ __('Hủy') }}</a>
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                            </svg>
                            {{ __('Lưu') }}
                        </button>
                    </div>
                </div>
            </x-slot:before>
        </x-admin.category.form>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function() {
            $('input[name="name"]').on('input', function (){
                const $container = $(this).closest('form');
                $container.find('input[name="meta_data[title]"]').val($(this).val());
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: 'textarea.mini-editor',
                height: 300,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
                    'insertdatetime', 'media', 'wordcount'
                ],
                menubar: 'edit insert view format tools',
                toolbar: '',
                license_key: 'gpl',
                promotion: false,
                entity_encoding : "raw",
                statusbar: false
            });

        });
        function convertBase64(file){
            return new Promise((resolve, reject) => {
                const fileReader = new FileReader();
                fileReader.readAsDataURL(file);

                fileReader.onload = () => {
                    resolve(fileReader.result);
                };

                fileReader.onerror = (error) => {
                    reject(error);
                };
            });
        }

        async function uploadImage(event, id){
            const file = $(event)[0].files;
            const base64 = await convertBase64(file[0]);
            document.getElementById(`featured_image_${id}`).src = base64;
        }
    </script>
@endsection
