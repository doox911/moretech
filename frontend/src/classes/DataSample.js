/**
 * Объект выборки данных
 */
class DataSample {

  /**
   * Конструктор
   *
   * @param {Object} args_object
   */
  constructor(args_object = {}) {
    this.id = args_object.id ?? null;
    this.name = args_object.name ?? '';

    const default_data = {
      headers: [],
      items: [],
    };

    if (args_object.data) {
      default_data.headers = args_object.data.headers;
      default_data.items = args_object.data.items;
    }

    this.data = default_data;
    this.settings = args_object.settings ?? {};
  }
}

export default DataSample;
