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