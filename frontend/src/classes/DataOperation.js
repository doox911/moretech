/**
 * Объект операции над данными
 */
class DataOperation {

  /**
   * Конструктор
   *
   * @param {Object} args_object
   */
  constructor(args_object = {}) {
    this.name = args_object.name ?? '';
    this.canonical_name = args_object.canonical_name ?? '';
    this.formula = args_object.formula ?? '';
  }
}

export default DataOperation;
