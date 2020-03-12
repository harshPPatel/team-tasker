To enable dark mode

```js
changeTheme() {
  this.$vuetify.theme.dark = true;
},
```

routes

/dashboard
/group/:id
/assigned (list of tasks)
/settings
/logout
/account/delete


Change icons from 'mdi-*' to 'icon'
  https://vuetifyjs.com/en/customization/icons#install-material-icons

  also update it using this: https://vuetifyjs.com/en/customization/icons#install-material-design-icons-js-svg and import only desired icon in that component! (or create UI folder with icons and just create v-icon component as showed in example. It will make easy to use in other components)
  
  remove material-design-icons-iconfont libary

refactor onMount method and move it in separate file

refactor API call code in seperate files and pass `this.$apollo` as parameter OR just import Vue in that file!

The way to edit group and delete it

show snackbars when any CRUD function is executed

IMPORTANT: Add validation rules to the add/edit task dialogues
IMPORTANT: Add error alert to each form and success snackbar to each forms!

IMPORTANT: make tweaks to make app look good! for example change the 'created At' in the individual group page, it is not a right way man!

IMPORTANT: try refactoring the code but not too much