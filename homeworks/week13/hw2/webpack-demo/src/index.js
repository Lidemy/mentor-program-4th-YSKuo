/* eslint no-undef: 0 */
/* eslint no-shadow: 0 */
/* eslint import/prefer-default-export: 0 */
/* eslint import/no-extraneous-dependencies: 0 */

import $ from 'jquery';
import { getComments, addComments } from './api';
import { appendCommentToDOM, appendStyle } from './utils';
import { cssTemplate, getLoadMoreButton, getForm } from './templates';

export function init(options) {
  let containerElement = null;
  let commentDOM = null;
  let lastId = null;
  let isEnd = false;

  const { siteKey } = options;
  const { apiUrl } = options;
  const loadMoreClassName = `${siteKey}-load-more`;
  const commentsClassName = `${siteKey}-comments`;
  const formClassName = `${siteKey}-add-comment-form`;
  const commentsSelector = `.${commentsClassName}`;
  const formSelector = `.${formClassName}`;

  containerElement = $(options.containerSelector);
  containerElement.append(getForm(formClassName, commentsClassName));
  appendStyle(cssTemplate);

  commentDOM = $(commentsSelector);

  function getNewComments() {
    const commentDOM = $(commentsSelector);
    $(`.${loadMoreClassName}`).hide();
    if (isEnd) {
      return;
    }
    getComments(apiUrl, siteKey, lastId, (data) => {
      if (!data.ok) {
        alert(data.message);
        return;
      }
      const comments = data.discussions;
      for (const comment of comments) {
        appendCommentToDOM(commentDOM, comment);
      }
      const { length } = comments;
      if (length === 0) {
        isEnd = true;
        $(`.${loadMoreClassName}`).hide();
      } else {
        lastId = comments[length - 1].id;
        const loadMoreButtonHTML = getLoadMoreButton(loadMoreClassName);
        $(commentsSelector).append(loadMoreButtonHTML);
      }
    });
  }

  // 1st load
  getNewComments();

  // clicking load-more button
  $(commentsSelector).on('click', `.${loadMoreClassName}`, () => {
    getNewComments();
  });

  // user adding comment
  $(formSelector).submit((e) => {
    e.preventDefault();
    const nicknameDOM = $(`${formSelector} input[name=nickname]`);
    const contentDOM = $(`${formSelector} textarea[name=content]`);
    const newCommentData = {
      site_key: siteKey,
      nickname: nicknameDOM.val(),
      content: contentDOM.val(),
    };
    addComments(apiUrl, siteKey, newCommentData, (data) => {
      if (!data.ok) {
        alert(data.message);
        return;
      }
      nicknameDOM.val('');
      contentDOM.val('');
      appendCommentToDOM(commentDOM, newCommentData, true);
    });
  });
}
