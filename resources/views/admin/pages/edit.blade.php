@extends('admin.theme.default')
@section('title', 'تعديل محتوى الصفحة')
@section('head')
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

    <div class="container-fluid">
        <div class="card mb-3">
          <div class="card-header">

          </div>
          <div class="card-body">
              <div class="table-responsive">
                <form method="POST" action="{{route('pages.update', $page->id)}}" class="my-5" novalidate>
                  @csrf
                  @method('PATCH')
                  <div class="mb-3">
                    <label for="slug" class="form-label">رابط الصفحة</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{$page->slug}}">
                    @error('slug')
                      <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label for="title" class="form-label">عنوان الصفحة</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{$page->title}}">
                    @error('title')
                      <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label for="content" class="form-label">مضمون الصفحة</label>
                    <textarea name="content" id="page-content" rows="5" class="form-control @error('content') is-invalid @enderror">
                      {{$page->content}}
                    </textarea>
                    @error('content')
                      <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                  </div>

                  <button type="submit" class="btn btn-outline-primary add-button">تعديل</button>
                </form>
          
              </div>
          </div>
        </div>
    </div>
 
@endsection

@section('script')
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
ClassicEditor.create(document.querySelector('#page-content'), editorConfig);
</script>

@endsection