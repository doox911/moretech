import DataSet from 'Classes/DataSet';

/**
 * Объект выборки данных
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
    this.dataset = null;
  }

  async loadDataSet() {
    if (!this.dataset) {
      this.dataset = await DataSet.fromUrl(this.url);

      this.loaded = true;
    }
  }

}

export default DataSource;
