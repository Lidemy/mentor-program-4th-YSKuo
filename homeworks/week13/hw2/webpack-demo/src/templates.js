/* eslint no-undef: 0 */
/* eslint no-shadow: 0 */

export const cssTemplate = '.card { margin-top: 20px; }';

export function getForm(className, commentsClassName) {
  return `
    <div>
      <form class="${className}">
        <div class="form-group">
          <label>暱稱</label>
          <input type="text" name="nickname" class="form-control" >
        </div>
        <div class="form-group">
          <div class="form-group">
            <label>留言內容</label>
            <textarea name="content" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      <div class="${commentsClassName}">
      </div>
    </div>
  `;
}

export function getLoadMoreButton(className) {
  return `<button class="${className} btn btn-outline-primary">載入更多</button>`;
}
