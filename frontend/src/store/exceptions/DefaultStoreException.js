/**
 * Исключение по умолчанию
 */
class DefaultException extends Error {

  /**
   * @param {string} message
   */
  constructor(message) {
    super(message);
    this.name = this.constructor.name;
  }
}

/**
 * Пользовательское исключение
 */
export default class DefaultStoreException extends DefaultException {

}
