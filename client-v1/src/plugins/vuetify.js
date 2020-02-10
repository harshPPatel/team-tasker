import Vue from 'vue';
import Vuetify from 'vuetify/lib';

import colors from 'vuetify/lib/util/colors';

Vue.use(Vuetify);

export default new Vuetify({
  theme: {
    primary: colors.indigo.base,
    secondary: colors.indigo.lighten4,
    accent: colors.grey.darken4,
  },
});
