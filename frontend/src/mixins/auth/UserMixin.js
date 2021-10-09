/**
 * Constants
 */
import { ActionTypes as AuthActionTypes } from '../../store/modules/auth/action_types';

/**
 * Mixins
 */
import ApplicationMixin from '../application/ApplicationMixin';

export default {

  mixins: [
    ApplicationMixin,
  ],

  computed: {},

  methods: {

    /**
     * Создать пользователя
     *
     * @param user Пользователь
     */
    async createUser(user) {
      await this.query(async () => {
        await this.$store.dispatch(AuthActionTypes.CREATE_USER, user);

        this.setSuccessSystemSnackbarMessages(['Успешно']);
      });
    },

    /**
     * Обновить пользователя
     *
     * @param user Пользователь
     */
    async updateUser(user) {
      await this.query(async () => {
        await this.$store.dispatch(AuthActionTypes.UPDATE_USER, user);

        this.setSuccessSystemSnackbarMessages(['Успешно']);
      });
    },
  },
};
