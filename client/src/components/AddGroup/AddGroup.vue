<template src="./AddGroup.html"></template>

<script>
export default {
  name: 'add-group',
  data: () => ({
    dialog: false,
    content: '<h1>Hello World</h1>',
    customToolbar: [
      ['bold', 'italic', 'underline'],
      ['list', 'align'],
      ['code-block'],
    ],
  }),
};
</script>
