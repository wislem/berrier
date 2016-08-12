@extends('berrier::admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/redactor/redactor.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/dropzone/dropzone.css')}}">
@stop

@section('content')

    <section class="content-header">
        <h1>
            Create new Post
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-10 col-md-12">
                <div class="box box-success">
                    @include('berrier::admin.posts.form', ['post' => $post])
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')
    <script src="{{asset('admin_assets/plugins/redactor/redactor.min.js')}}"></script>
    <script src="{{asset('admin_assets/plugins/redactor/plugins/table/table.js')}}"></script>
    <script src="{{asset('admin_assets/plugins/redactor/plugins/video/video.js')}}"></script>

    <script src="{{asset('admin_assets/dist/js/pages/form.js')}}"></script>

    <script src="{{asset('admin_assets/plugins/dropzone/dropzone.js')}}"></script>
    <script src="{{asset('admin_assets/plugins/sortable/sortable.min.js')}}"></script>
    <script>
        $(function(){
            Dropzone.autoDiscover = false;
            var preload_media = false;

                    @if(count(old('media')))
                        var preload_media = true;
            var mockFiles = [];

            @foreach(old('media') as $medium)
                @if(\File::exists(storage_path().'/app'.$medium))
                    mockFiles.push({ name: '{{basename($medium)}}', size: '{{\File::size(storage_path().'/app'.$medium)}}', path: '{{$medium}}', thumb: '{{Croppa::url($medium, 120, 120)}}' });
                    @endif
                @endforeach
            @endif

            var mediaZone = new Dropzone('#mediazone', {
                        url: '/admin/media',
                        method: 'POST',
                        parallelUploads: 3,
                        maxFilesize: 3,
                        addRemoveLinks: true,
                        acceptedFiles: 'image/*',
                        previewTemplate: $('.preview-template').html(),
                        init: function(){
                            if(preload_media) {
                                var mediaZone = this;

                                $.each(mockFiles, function(i, mockFile){
                                    var trueMockFile = {name: mockFile.name, size: mockFile.size};
                                    mediaZone.files.push(trueMockFile);
                                    mediaZone.options.addedfile.call(mediaZone, trueMockFile);
                                    mediaZone.options.thumbnail.call(mediaZone, trueMockFile, mockFile.thumb);

                                    var input = document.createElement("input");
                                    input.type = "hidden";
                                    input.name = "media[]";
                                    input.value = mockFile.path;
                                    mediaZone.files.slice(-1)[0].previewTemplate.appendChild(input); // put it into the DOM
                                });

                                $('#mediazone').find('.dz-message').css('display', 'none');
                                var mediazone = document.getElementById('mediazone');
                                Sortable.create(mediazone, {
                                    draggable: '.dz-preview'
                                });
                            }
                        }
                    });

            mediaZone.on('sending', function(file, xhr, formData) {
                $('#media').find('.dz-message').css('display', 'none');
                formData.append('folder', 'posts');
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            });

            mediaZone.on("success", function(file, response) {
                if(response.error) {
                    $.bootstrapGrowl('Something went wrong', {type: 'danger'});
                }else {
                    var input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "media[]"; // set the CSS class
                    input.value = response.path;
                    file.previewTemplate.appendChild(input); // put it into the DOM
                    var mediazone = document.getElementById('mediazone');
                    Sortable.create(mediazone, {
                        draggable: '.dz-preview'
                    });
                }
            });

            mediaZone.on('removedfile', function(file) {
                var json = JSON.parse(file.xhr.response);

                if($('.dz-preview').length == 0) {
                    $('#mediazone').find('.dz-message').css('display', 'block');
                }

                $.ajax({
                    url: '/admin/media/0',
                    method: 'POST',
                    data: { _method: 'DELETE', _token: $('meta[name="csrf-token"]').attr('content'), path: json.path },
                }).done(function(response){
                    $.bootstrapGrowl(response.msg, {type: response.msg_type});
                })
            });

            $('#category_id').change(function(){
                var value = $(this).val();

                if(value > 0) {
                    $.ajax({
                        url: '/admin/meta-fields/' + $(this).val()
                    }).success(function (response) {
                        $('#metafields').html(response);
                    }).error(function (response) {
                        console.log(response);
                        $.bootstrapGrowl(response.msg, {type: 'danger'});
                    })
                }else {
                    $('#metafields').html('<div class="alert alert-info">Choose a category to load its attributes.</div>');
                }
            })
        })
    </script>
@stop