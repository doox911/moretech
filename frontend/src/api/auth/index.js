/**
 * Constants
 */
import { API_VERSION } from '../../constants/api';

/**
 * Вход в систему
 *
 * @param {string} email Электронная почта
 * @param {string} password Пароль
 */
export function login(email, password) {
  return window.axios.post(`/api/${API_VERSION}/auth/login`, {
    email: email,
    password: password,
  });
}

/**
 * Выход из системы
 */
export const logout = () => window.axios.post(`/api/${API_VERSION}/auth/logout`);

/**
 * Обновить токен
 */
export const refresh = () => window.axios.post(`/api/${API_VERSION}/auth/refresh`);

/**
 * Создать пользователя
 *
 * @param user Пользователь
 */
export const createUser = user => window.axios.post(`/api/${API_VERSION}/auth/register/`, user);
