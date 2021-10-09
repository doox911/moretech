/**
 * Types
 */
import { MutationTypes } from '../../store/modules/application/mutation_types';

/**
 * Exceptions
 */
import DefaultStoreException from '../../store/exceptions/DefaultStoreException';

export default {

  watch: {
    system_snackbar(value) {
      this.$store.commit(MutationTypes.TOGGLE_SYSTEM_SNACKBAR, value);
    },
  },

  computed: {

    /**
     * Состояние глобального ожидания
     */
    global_loading() {
      return this.$store.getters.getGlobalLoading;
    },

    /**
     * Состояние левого меню
     */
    v_navigation_drawer() {
      return this.$store.getters.getVNavigationDrawer;
    },

    /**
     * Состояние верхней панели
     */
    v_app_bar() {
      return this.$store.getters.getVAppBar;
    },

    /**
     * Состояние system snackbar
     */
    system_snackbar() {
      return this.$store.getters.getSystemSnackbar;
    },

    /**
     * Сообщения для system snackbar
     */
    system_snackbar_messages() {
      return this.$store.getters.getSystemSnackbarMessages;
    },
  },

  methods: {

    /**
     * Копирование в буфер
     *
     * @param {string} identifier Селектор
     * @protected
     */
    copy(identifier) {
      const node = document.querySelector(identifier);

      node.setAttribute('type', 'text');
      node.select();

      document.execCommand('copy');

      node.setAttribute('type', 'hidden');

      const ws = window.getSelection();

      if (ws) {
        ws.removeAllRanges();
      }
    },

    /**
     * Переключить состояние левого меню(показать/скрыть)
     *
     * @protected
     */
    toggleVNavigationDrawer() {
      this.$store.commit(MutationTypes.TOGGLE_V_NAVIGATION_DRIVER);
    },

    /**
     * Скрыть левое меню
     *
     * @protected
     */
    hideVNavigationDrawer() {
      this.$store.commit(MutationTypes.UPDATE_V_NAVIGATION_DRIVER, false);
    },

    /**
     *
     * @protected
     */
    toggleSystemSnackbar() {
      this.clearSystemSnackbarMessages();
      this.$store.commit(MutationTypes.TOGGLE_SYSTEM_SNACKBAR);
    },

    /**
     * Успешные сообщения
     *
     * @param {string[]} messages
     * @protected
     */
    setSuccessSystemSnackbarMessages(messages) {
      this.setSystemSnackbarType('success');
      this.$store.commit(MutationTypes.SET_SYSTEM_SNACKBAR_MESSAGES, messages);
      this.$store.commit(MutationTypes.TOGGLE_SYSTEM_SNACKBAR);
    },

    /**
     * Сообщения с ошибкой
     *
     * @param messages
     * @protected
     */
    setErrorsSystemSnackbarMessages(messages) {
      this.setSystemSnackbarType('error');
      this.$store.commit(MutationTypes.SET_SYSTEM_SNACKBAR_MESSAGES, messages);
      this.$store.commit(MutationTypes.TOGGLE_SYSTEM_SNACKBAR);
    },

    /**
     * Очистить сообщения снекбара
     *
     * @protected
     */
    clearSystemSnackbarMessages() {
      this.$store.commit(MutationTypes.CLEAR_SYSTEM_SNACKBAR_MESSAGES);
    },

    /**
     * Тип показываемого снекбара
     *
     * @param {string} type
     * @protected
     */
    setSystemSnackbarType(type) {
      this.$store.commit(MutationTypes.SET_TYPE_SYSTEM_SNACKBAR, type);
    },

    /**
     * Выполнить запрос к серверу
     *
     * @param {Function} tryCallback Функция обратного вызова с действиями, которые необходимо выполнить в блоке try{}
     * @param {Function} catchCallback Функция обратного вызова с действиями, которые необходимо выполнить в блоке catch{}
     * @param {Function} finallyCallback Функция обратного вызова с действиями, которые необходимо выполнить в блоке finally{}
     * @protected
     */
    async query(
      tryCallback = async () => undefined,
      catchCallback = async () => undefined,
      finallyCallback = async () => undefined,
    ) {
      try {
        await tryCallback();
      } catch (e) {
        await catchCallback();

        const errors = e instanceof DefaultStoreException
          ? [e.message]
          : [...e.response.data.messages];

        this.setErrorsSystemSnackbarMessages(errors);
      } finally {
        await finallyCallback();
      }
    },

    /**
     * Скачать Blob-файл
     *
     * @param {Blob} blob Blob-объект
     * @param {string} filename Наименование файла
     * @protected
     */
    downloadBlob(blob, filename) {
      const url = window.URL.createObjectURL(blob);
      const link = document.createElement('a');

      link.href = url;
      link.setAttribute('download', filename);

      document.body.appendChild(link);

      link.click();
      link.remove();
    },
  },
};
