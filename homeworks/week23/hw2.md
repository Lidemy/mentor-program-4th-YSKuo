## 為什麼我們需要 Redux？
專案越做越大時，有可能有非常多的 state 需要管理，而這些 state 往往會在許多 components 用到，例如 Facebook 中好友的上線狀態，會在 Messenger 上顯示也會在 Contact 還有該好友的個人頁上顯示。
因為有許多 components 會共用 state，如果由 parent 傳 props 給 children 會有 prop drilling 的不便，所以需要使用 Redux 的 Provider 和 store 來幫我們傳遞 props。

此外，因為 state 讓許多 components 共用的關係，所以有許多地方都可能可以更改 state，若有 bug 產生則難以找到源頭，所以需要使用 Redux 來 dispatch actions 到 store 以更新資料，這樣只要統一管理 dispatch 就好。

## Redux 是什麼？可以簡介一下 Redux 的各個元件跟資料流嗎？
Redux 幫助我們管理 state。

app 的 state 會存在 store 裡面，而所有對 state 的操作必須通過 dispatch，這個 dispatch 會接受一個參數 action，用來描述我們想要怎麼改變 state。
dispatch 會接受 action 後會發送給 reducer，而 reducer 是處理 state 的 function，它會接受當前的 state 和 action，最後傳出一個經過改變的 state。

動圖參考
![](https://redux.js.org/assets/images/ReduxDataFlowDiagram-49fa8c3968371d9ef6f2a1486bd40a26.gif)

## 該怎麼把 React 跟 Redux 串起來？

React 和 Redux 是兩個相互獨立的 library，但可透過 React Redux 這個 library 串連。

可以使用 `useSelector` 來擷取 store state 的資料，同時它也會 subscribe Redux store，即 state 有變化時 `useSelector` 也會擷取更新後的資料出來。

而要對 state 進行動作時，可以使用 `useDispatch` 來 dispatch actions。
