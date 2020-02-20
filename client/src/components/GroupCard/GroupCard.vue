<template src="./GroupCard.html"></template>

<script>
import { format } from 'fecha';

export default {
  name: 'group',
  props: ['group'],
  data: () => ({
    showDescription: false,
  }),
  computed: {
    formattedCreatedAt: (data) => format(+data.group.createdAt, 'mediumDate'),
  },
};
</script>
