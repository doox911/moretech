/**
 * Объект выборки данных
 */
class DataSet {

  /**
   * Конструктор
   *
   * @param {Object} args_object
   */
  constructor(args_object = {}) {
    const id = (args_object.id ?? '') + '_' + new Date().getTime();

    this.id = id;
    this.name = args_object.name ?? '';
    this.title = args_object.title ?? '';
    this.schema = args_object.schema ?? {};
    this.settings = args_object.settings ?? {};
  }

  /**
   * Создание объекта датасета из ссылки на данные
   *
   * @param {string} url
   */
  static async fromUrl(url) {
    const promise = window.axios.get(url);
    const data = (await promise).data;

    const schema = data.resources.find(resource => resource.format === 'json' && Boolean(resource.mediatype)).schema;

    return new DataSet({
      id: data.datahub.hash,
      name: data.name,
      title: data.title,
      schema: schema,
    });
  }

  /**
   * Возвращает копию текущего объекта, с другим ID
   *
   * @return {DataSet}
   */
  getCopy() {
    return new DataSet(this);
  }
}

export default DataSet;
