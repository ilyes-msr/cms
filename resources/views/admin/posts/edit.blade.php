@extends('layouts.main')

@section('style')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css">
<script type="importmap">
  {
    "imports": {
      "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.js",
      "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.0.0/"
    }
  }
  </script>
  <style>
    h2 {
      font-size: 1.9rem !important  
    }
    input, select, textarea,button {
      /* border: none !important */
    }

    input[type="file"]::file-selector-button {
            background-color: #000;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .add-button {
          background-color: #000;
          color: white;
          border-radius: 5px;
          cursor: pointer;
          transition: .3s all ease-in-out
        }
        
        .add-button:hover, .add-button:active {
          background-color: #eee !important;
          color: black !important;
          border: 1px solid black !important
        }

        /* ///////////////////////////////////// */
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400;1,700&display=swap');

@media print {
	body {
		margin: 0 !important;
	}
}

.main-container {
	font-family: 'Lato';
	width: fit-content;
	margin-left: auto;
	margin-right: auto;
}

.ck-content {
	font-family: 'Lato';
	line-height: 1.6;
	word-break: break-word;
}

.editor-container_classic-editor .editor-container__editor {
	min-width: 795px;
	max-width: 795px;
}

  </style>
@endsection

@section('content')
  <div class="col-md-12">
      <h2 class="h4 my-2">
          تعديل المنشور
      </h2>
  </div>
      <form method="POST" action="{{route('posts.update', $post->id)}}" class="my-5 px-5" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PATCH')
        <div class="mb-3">
          <label for="title" class="form-label">عنوان المنشور</label>
          <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" aria-describedby="emailHelp" name="title" value="{{$post->title}}">
          @error('title')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
      
        <div class="form-row">
          <div class="col-lg-5 form-group">
              <label for="slug">الإسم اللطيف </label>
              <input type="text" class="form-control" name="slug" placeholder="" value="{{$post->slug}}">
          </div>

          <div class="col-lg-6 form-group">
            <input type="checkbox" class="" name="approved" id="approved"  value="{{$post->approved}}" {{$post->approved ? 'checked' : ''}}>
            <label for="approved">نشر الموضوع </label>
          </div>
      </div>

        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">محتوى المنشور</label>
          <textarea name="body" id="body" rows="5" class="form-control @error('body') is-invalid @enderror">{{$post->body}}
          </textarea>
          @error('body')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category-id">
            <option value="" selected disabled>اختر صنف المنشور</option>
            @forelse($categories as $category)
              <option value="{{$category->id}}" {{$post->category_id == $category->id ? 'selected' : ''}}>{{$category->title}}</option>
            @empty
            
            @endforelse
          </select>
          @error('category_id')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <input type="file" name="img_path" id="img-path" class="form-control @error('img_path') is-invalid @enderror" accept="image/*" onchange="readCoverImage(this)">
          @error('img_path')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <div class="row">
          <img src="{{asset('storage/' . $post->img_path)}}" alt="" id="cover-image-thumb" class="col-2" width="100" height="100">
          <span class="input-name col-6"></span>
        </div>
        <button type="submit" class="btn btn-primary add-button mt-3">تعديل</button>
      </form>
    </div>
  </div>
</div>

@endsection

@section('script')

  <script>
            function readCoverImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.querySelector('#cover-image-thumb').setAttribute('src', e.target.result);
                };
                
                reader.readAsDataURL(input.files[0]);
            }
        }

  </script>
  <script type="module">
    import {
ClassicEditor,
AccessibilityHelp,
Autoformat,
AutoImage,
Autosave,
BlockQuote,
Bold,
CloudServices,
Essentials,
Heading,
ImageBlock,
ImageCaption,
ImageInline,
ImageInsertViaUrl,
ImageResize,
ImageStyle,
ImageTextAlternative,
ImageToolbar,
ImageUpload,
Indent,
IndentBlock,
Italic,
Link,
LinkImage,
List,
ListProperties,
MediaEmbed,
Paragraph,
PasteFromOffice,
SelectAll,
Table,
TableCaption,
TableCellProperties,
TableColumnResize,
TableProperties,
TableToolbar,
TextTransformation,
TodoList,
Underline,
Undo
} from 'ckeditor5';

import translations from 'ckeditor5/translations/ar.js';

const editorConfig = {
toolbar: {
  items: [
    'undo',
    'redo',
    '|',
    'selectAll',
    '|',
    'heading',
    '|',
    'bold',
    'italic',
    'underline',
    '|',
    'link',
    'mediaEmbed',
    'insertTable',
    'blockQuote',
    '|',
    'bulletedList',
    'numberedList',
    'todoList',
    'outdent',
    'indent',
    '|',
    'accessibilityHelp'
  ],
  shouldNotGroupWhenFull: false
},
plugins: [
  AccessibilityHelp,
  Autoformat,
  AutoImage,
  Autosave,
  BlockQuote,
  Bold,
  CloudServices,
  Essentials,
  Heading,
  ImageBlock,
  ImageCaption,
  ImageInline,
  ImageInsertViaUrl,
  ImageResize,
  ImageStyle,
  ImageTextAlternative,
  ImageToolbar,
  ImageUpload,
  Indent,
  IndentBlock,
  Italic,
  Link,
  LinkImage,
  List,
  ListProperties,
  MediaEmbed,
  Paragraph,
  PasteFromOffice,
  SelectAll,
  Table,
  TableCaption,
  TableCellProperties,
  TableColumnResize,
  TableProperties,
  TableToolbar,
  TextTransformation,
  TodoList,
  Underline,
  Undo
],
heading: {
  options: [
    {
      model: 'paragraph',
      title: 'Paragraph',
      class: 'ck-heading_paragraph'
    },
    {
      model: 'heading1',
      view: 'h1',
      title: 'Heading 1',
      class: 'ck-heading_heading1'
    },
    {
      model: 'heading2',
      view: 'h2',
      title: 'Heading 2',
      class: 'ck-heading_heading2'
    },
    {
      model: 'heading3',
      view: 'h3',
      title: 'Heading 3',
      class: 'ck-heading_heading3'
    },
    {
      model: 'heading4',
      view: 'h4',
      title: 'Heading 4',
      class: 'ck-heading_heading4'
    },
    {
      model: 'heading5',
      view: 'h5',
      title: 'Heading 5',
      class: 'ck-heading_heading5'
    },
    {
      model: 'heading6',
      view: 'h6',
      title: 'Heading 6',
      class: 'ck-heading_heading6'
    }
  ]
},
image: {
  toolbar: [
    'toggleImageCaption',
    'imageTextAlternative',
    '|',
    'imageStyle:inline',
    'imageStyle:wrapText',
    'imageStyle:breakText',
    '|',
    'resizeImage'
  ]
},
language: 'ar',
link: {
  addTargetToExternalLinks: true,
  defaultProtocol: 'https://',
  decorators: {
    toggleDownloadable: {
      mode: 'manual',
      label: 'Downloadable',
      attributes: {
        download: 'file'
      }
    }
  }
},
list: {
  properties: {
    styles: true,
    startIndex: true,
    reversed: true
  }
},
table: {
  contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
},
translations: [translations]
};
ClassicEditor.create(document.querySelector('#body'), editorConfig);
  </script>

@endsection