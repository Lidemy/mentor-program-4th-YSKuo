## Webpack 是做什麼用的？可以不用它嗎？
Webpack 是 module bundler，可以協助開發者把模組包在一起，任何資源(JS, image, CSS...)都可以打包；一般來說需要 compile 的檔案會放在 src 這麼資料夾，webpack 再由 src 輸出成一個個模組。

專案開發可以不用 webpack，就像過去幾週的作業一樣，即使沒有 webpack 我們一樣可以完成一個個專案；但隨著專案規模越來越大，勢必會需要使用各種不同的資源或撰寫許多功能，如果沒有讓專案內容模組化，很容易會產生維護困難，所以才會需要利用 webpack 來打包我們的資源。

## gulp 跟 webpack 有什麼不一樣？
- gulp
  - task manager 任務處理器
  - 只要寫好任務，gulp 基本上可以完成任何事情
- webpack
  - 主要是用來把模組打包，只是打包過程經常利用 loader，來將檔案 compile 成瀏覽器可以支援的內容，
  - 因 gulp 也常用來 complie 檔案，所以在這件事上 webpack 和 gulp 能做的差不多
  
## CSS Selector 權重的計算方式為何？

|     | !import | inline style | id | class <br> attribute <br> pseudo-class | tag | 
| --- | ------- | ------------ | -- | -------------------------------------- | --- |
| 權重 | 0       | 0            |  0 | 0                                      |  0  |

大原則：越詳細的權重高
```
!import > inline style | attribute | pseudo-class > id > class > tag
```
權重一樣的話，以寫在後面的為準。

### 圖解
![CSS Specificity](https://muki.tw/wordpress/wp-content/uploads/2015/07/CSS-Specificity-full.png)
[圖源](https://cssspecificity.com/)
