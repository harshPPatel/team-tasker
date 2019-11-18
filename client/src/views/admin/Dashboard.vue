<template>
  <div class="container mt-5">
    <h1>Welcome, Admin!</h1>
    <div class="flex-container mt-5">
      <div class="">
        <h3>Assigned Tasks</h3>
      </div>
      <div class="ml-auto text-right">
        <button type="button" class="btn btn-success"
          data-toggle="modal" data-target="#addGroupModal">Add Group</button>
      </div>
    </div>
    <hr>
  </div>
</template>

<script>
export default {
  name: 'admin-dashboard',
};
</script>
