## 為什麼我們需要 React？可以不用嗎？

React 方便我們管理 UI 所有物件的狀態，做專案可以不用 React，就算不用 jQuery 也可以完成許多專案，不過有使用這些工具的話可讓我們的開發更快速。

## React 的思考模式跟以前的思考模式有什麼不一樣？

React 的核心是把物件分為一個個 component，然後利用 state 來管理這些 component 在畫面上的樣子；若有 state 改變，React 就會透過 virtual DOM 比對變化 state 前後 component 的差異，再將有變動的 component 重新 render。

## state 跟 props 的差別在哪裡？

`state` 是讓 component 控制自己的狀態
`props` 是讓外部對 component 自己進行配置