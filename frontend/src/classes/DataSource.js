import DataSet from 'Classes/DataSet';

/**
 * Объект источника данны
 */
class DataSource {

  /**
   * Конструктор
   *
   * @param {Object} args_object
   */
  constructor(args_object = {}) {
    this.name = args_object.name ?? '';
    this.url = args_object.url ?? '';
    this.loaded = false;
    this.loading = false;
    this.dataset = null;
  }

  /**
   * Загружает связанный датасет в текущий объект
   */
  async loadDataSet() {
    if (!this.dataset) {
      this.loading = true;

      this.dataset = await DataSet.fromUrl(this.url);

      this.loading = false;

      this.loaded = true;
    }
  }

}

export default DataSource;
