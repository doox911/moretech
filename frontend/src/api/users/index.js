/**
 * Constants
 */
import { API_VERSION } from '../../constants/api';

/**
 * Данные всех пользователей
 */
export const users = () => window.axios.get(`/api/${API_VERSION}/users`);

/**
 * Пользователь с ролями и привилегиями
 */
export const usersWithRolesAndPermissions = () => window.axios.get(`/api/${API_VERSION}/users/with_roles_and_permissions`);

/**
 * Данные пользователя
 */
export const user = () => window.axios.get(`/api/${API_VERSION}/users/user_by_token`);

/**
 * Обновить пользователя
 *
 * @param user Пользователь
 */
export const updateUser = user => window.axios.put(`/api/${API_VERSION}/users/${user.id}`, user);
