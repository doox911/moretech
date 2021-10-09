<template>
  <v-container
    class="fill-height fluid"
  >
    <v-row
      align="center"
      justify="center"
    >
      <v-col class="col-xs-12 col-sm-7 col-md-5">
        <v-form
          ref="form"
          v-model="is_valid_form"
        >
          <v-card
            elevation="5"
            max-width="400"
            shaped
          >
            <v-row>
              <v-col class="text-center">
                <h3 class="font-weight-light user-select-none vtb-color--text">
                  Вход систему
                </h3>
              </v-col>
            </v-row>
            <v-row>
              <v-col class="px-6 pb-0">
                <v-text-field
                  v-model="email"
                  :rules="[rules.required]"
                  :disabled="global_loading"
                  label="Email"
                  placeholder=" "
                  outlined
                  @keyup.enter="componentLogin"
                />
              </v-col>
            </v-row>
            <v-row>
              <v-col class="px-6 py-0">
                <v-text-field
                  v-model="password"
                  :rules="[rules.required]"
                  :disabled="global_loading"
                  :append-icon="append_icon"
                  :type="input_password_type"
                  label="Пароль"
                  placeholder=" "
                  outlined
                  @keyup.enter="componentLogin"
                  @click:append="see_password = !see_password"
                />
              </v-col>
            </v-row>
            <v-row>
              <v-col class="col-xs-12 col-md-6 px-6">
                <v-btn
                  :loading="global_loading"
                  color="vtb-color"
                  block
                  x-large
                  rounded
                  outlined
                  @click="reset"
                >
                  Очистить
                </v-btn>
              </v-col>
              <v-col class="col-xs-12 col-md-6 px-6">
                <v-btn
                  :loading="global_loading"
                  color="vtb-color"
                  block
                  x-large
                  outlined
                  rounded
                  :disabled="!login_submit_disabled"
                  @click="componentLogin"
                >
                  Вход
                </v-btn>
              </v-col>
            </v-row>
          </v-card>
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import AuthMixin from '../../mixins/auth/AuthMixin';

  export default {
    mixins: [
      AuthMixin,
    ],

    data() {
      return {

        /**
         * Валидна ли форма
         */
        is_valid_form: true,

        /**
         * Показать/скрыть пароль
         */
        see_password: false,

        /**
         * Электронный адрес
         */
        email: '',

        /**
         * Пароль
         */
        password: '',

        /**
         * Правила для текстовых полей
         */
        rules: {
          required: v => !!v || 'Обязательное поле',
        },
      };
    },

    computed: {

      form() {
        return this.$refs.form;
      },

      /**
       * Флаг блокировки кнопки "вход"
       *
       * @return {boolean}
       */
      login_submit_disabled() {
        return !!this.email && !!this.password;
      },

      /**
       * Имя иконки для поля - пароль
       *
       * Если не показываем пароль - зачёркнуты глазик. Иначе не зачёркнутый.
       *
       * @return {string}
       */
      append_icon() {
        return this.see_password ? 'mdi-eye' : 'mdi-eye-off';
      },

      /**
       * Тип поля - пароль
       *
       * Если не показываем пароль - text. Иначе - password.
       *
       * @return {string}
       */
      input_password_type() {
        return this.see_password ? 'text' : 'password';
      },
    },

    methods: {

      /**
       * Вход в систему
       *
       * @return {Promise}
       */
      async componentLogin() {

        /**
         * Если заполнены поля формы
         */
        if (this.login_submit_disabled) {

          /**
           * Если форма заполнена корректно
           */
          if (this.form.validate()) {
            try {
              await this.login(this.email, this.password);

              await this.$router.push({
                name: 'Home',
              });
            } catch (e) {

            }
          }
        }
      },

      /**
       * Сбросить поля формы
       */
      reset() {
        this.form.reset();
      },
    },
  };
</script>
