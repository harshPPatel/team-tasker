<template>
  <vue-editor v-model="content"
    placeholder="Enter here..."
    :editor-toolbar="customToolbar"/>
</template>

<script>
export default {
  name: 'editor',
  props: ['content'],
  data: () => ({
    customToolbar: [
      ['bold', 'italic', 'underline', 'strike'],
      [
        { align: '' },
        { align: 'center' },
        { align: 'right' },
        { align: 'justify' },
      ],
      [{ header: 1 }, { header: 2 }],
      ['blockquote', 'code-block'],
      [{ list: 'ordered' }, { list: 'bullet' }],
      [{ script: 'sub' }, { script: 'super' }],
      [{ indent: '-1' }, { indent: '+1' }],
      ['link', 'formula'],
    ],
  }),
};
</script>
