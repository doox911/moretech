/* -----------------------------------------------------------------------------
 | Правила создания модулей
 |
 | - Все модули помещаются в директорию ./modules
 | - В директории ./modules должна присутствовать директория с названием модуля
 | - Название директории должно быть написано в snake_case
 | - Название модуля и директории должны совпадать
 | - Корневой файл модуля должен иметь название index.js
 |
 | Алгоритм загрузки модулей
 |
 | - Рекурсивно находим все пути к файлам модулей
 | - По регулярному выражению получаем имя модуля
 | Пример: для модуля Store/modules/auth/index.js, имя - auth
 | - Создаём экземпляр модуля
 | - Создаём свойство с именем модуля, где значение свойства - модуль.
 -------------------------------------------------------------------------------
*/

/**
 * Загрузить Vuex - модули(Store - модули)
 */
export default function loadVuexModules() {
  const VuexModules = {};

  const context = require.context('./modules', true, /index\.js$/i);

  context.keys().map(path => {
    const find = /(?<module_name>\w+)\/index\.js/.exec(path);

    if (find && find.groups) {
      const module_name = find.groups.module_name;
      const module = context(path);

      VuexModules[module_name] = module[module_name];
    }
  });

  return VuexModules;
}
