/**
 * Constants
 */
import { ROOT } from '../../store/constants';
import { ActionTypes } from '../../store/modules/auth/action_types';
import { MutationTypes as AuthMutationTypes } from '../../store/modules/auth/mutation_types';

/**
 * Mixins
 */
import ApplicationMixin from '../application/ApplicationMixin';

export default {

  mixins: [
    ApplicationMixin,
  ],

  computed: {

    /**
     * Авторизован ли пользователь
     *
     * @return {boolean}
     * @protected
     */
    isAuth() {
      return this.$store.getters.isAuth;
    },

    /**
     * Проверка пользователя на супер-администратора
     *
     * @return {boolean}
     * @protected
     */
    is_super_admin() {
      return this.$store.getters.isSuperAdmin;
    },

    /**
     * Проверка пользователя на администратора
     *
     * @return {boolean}
     * @protected
     */
    is_admin() {
      return this.$store.getters.isAdmin;
    },

    /**
     * Проверка пользователя на тип прав пользователя
     *
     * @return {boolean}
     * @protected
     */
    is_user() {
      return this.$store.getters.isUser;
    },

    /**
     * Проверка на наличие прав администратора или супер администратора
     *
     * @return {boolean}
     * @protected
     */
    is_super_admin_or_admin() {
      return this.$store.getters.isSuperAdminOrAdmin;
    },
  },

  methods: {

    /**
     * Проверка полномочий по роли или привилегии
     *
     * @param {string} rights Наименование роли/привилегии
     * @return {boolean}
     * @protected
     */
    userCan(rights) {
      return this.$store.getters.userCan(rights);
    },

    /**
     * Вход в систему
     *
     * @return {Promise<void>}
     * @protected
     */
    async login(email, password) {
      await this.query(async () => {
        await window.axios.get('/sanctum/csrf-cookie');
        await this.$store.dispatch(ActionTypes.LOGIN, {
          email,
          password,
        });
      });
    },

    /**
     * Выход из системы
     *
     * @return {Promise<void>}
     * @protected
     */
    async logout() {
      await this.query(async () => {
        await this.$store.dispatch(AuthMutationTypes.LOGOUT);

        this.$store.commit(ROOT.ROOT_RESET_MODULES_STATE);
      });
    },
  },
};
