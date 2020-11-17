## 請列出 React 內建的所有 hook，並大概講解功能是什麼

- `useState`
  - 可用來在 function component 裡面增加 React state。
- `useEffect`
  - render 後需要進行的 function，可以加在這個 Hook 裡。
  - 例如希望每次 render 後，可以把某些資訊存在 localStorage 裡，就可以用這個 Hook 完成。
  - 此外，可以傳入第二個參數作為 dependencies 且它須為 array，`useEffect` 會依據它判斷是否執行第一個參數的 function。
- `useLayoutEffect`
  - `useLayoutEffect` 在畫畫面之前執行，而 `useEffect` 是在畫畫面之後執行。
- `useContext` 
  - 可用來解決 prop drilling，而 prop drilling 是指當有多層 component 要傳 props 時，中間每一層的 component 都要個別寫上 props。
  - 透過 `useContext` 這個 Hook，中間沒有用到 props 的 component 就不需要寫上 props。
- `useReducer`
  - `useReducer` 是用來管理狀態和描述動作的，同時也是 `useState` 的替代方案。
  - `useReducer` 會接受一個 reducer，然後回傳現在的 state 和 dispatch。
  - 其中，reducer 是用 array 的 method `reduce()` 來命名的，可以把一連串的值 reduce 成單一值，也就是說 reducer 會依照先前的 state 和一個 action 來計算一個新的 state。
  - dispatch 則是指 dispatch function，這個 function 會接收一個 action 來決定 state 怎麼變化。
- `useCallback`
  - 讓 React 記住 Object/Function 的記憶體位址，以防它被當 props 傳遞時，因 parent component 重新渲染而該 Object 也跟著被重新分配記憶體位址。
  - 用法和 `useEffect` 有點像，在第二個參數傳入 dependencies，當那些 dependencies 沒有變時，那這個第一個參數裡的 function 不會改變。
- `useMemo`
  - 讓 React 記住 function 的回傳值，`useMemo` 只會在 dependencies 改變時才重新計算 memoized 的值。
  - 可用來把包在其中的 function 運算結果 return，這樣就不會在每次重新渲染時都執行一次元件的 function。
- `useRef`
  - 可用來存放 DOM 以方便操縱 DOM，也可用來存放會變化的值，`useRef` 不會造成 re-render。
- `useImperativeHandle`
  - 將 children component 的某些函式透過 `ref` 的方式 開放給 parent 呼叫
- `useDebugValue`
  - 用來在 React DevTools 中顯示自訂義 hook 的標籤

## 請列出 class component 的所有 lifecycle 的 method，並大概解釋觸發的時機點

- `constructor`
  - component 被建立的時候自動執行的 function，即在該 component 被 mount 之前被執行。
- `getDerivedStateFromProps`
  - 在 component 被 render 前執行。
- `shouldComponentUpdate(nextProps, nextState)`
  - 在 `getDerivedStateFromProps` 和 render 之間的時機點執行，可以通過這個方法控制 component 是否重新 render。
  - 改變 state 後 call 這個 method，如果返回 false 則 component 不會重新 render，預設為 true。
  - 這個 method 在 React.js 性能優化上非常有用。若某些內容沒有變的話就不需要重新 render，因此可以用 `shouldComponentUpdate` 來控制是否 update。
- `componentDidMount`
  - component 被掛載（mount）完成以後，也就是 DOM 元素已經插入頁面後調用。
- `componentDidUpdate`
  - component 重新 render 時執行，但不會在第一次 render 就執行。
- `componentWillUnmount`
  - component 對應的 DOM 元素從頁面中刪除之前調用。
  - 用來清除不會用到的功能。

### 以下都被官方標為過時
- `UNSAFE_componentWillMount`
  - component mount 開始之前執行。
- `UNSAFE_componentWillReceiveProps(nextProps)`
  - component 從 Parent component 接收到新的 props 之前調用。
- `UNSAFE_componentWillUpdate`
  - component 開始重新 render 之前調用。

## 請問 class component 與 function component 的差別是什麼？

- Class component
  1. 以 class 建立的 react component。
  2. 用 `render` 這個 function 回傳的值來渲染內容。
  3. 在 `constructor` 定義 `state`，並用 `setState` 來改變 `state` 的內容；引用 `state` 和 `setState` 時都需加上 `this`。
  4. 利用 lifecycle 的 method 來定義 render 前後要進行的內容。
  5. 內部定義的 function 若非 arrow function 的話，則需要在 `constructor` 中 `bind(this)`，才能在呼叫它時知道指向哪個 `this`。
- Function component
  1. 用 function 建立的 react component，可以接受 `props` 作為參數
  2. 用 function 本身回傳的值來渲染內容。
  3. 主要用 `useState` 定義 state 以及改變 state 的 method。
  4. 主要用 `useEffect` 和來定義 render 後要進行的內容。

## uncontrolled 跟 controlled component 差在哪邊？要用的時候通常都是如何使用？

Controlled 和 Uncontrolled Components 用來描述 React 表單 input 不同的形式，React 官方建議一般應該使用 controlled components。

### Uncontrolled Component
- input 沒有被 React 控制。
- 像是一般 HTML 表單元素一樣，元素的值沒有和 React 綁在一起，所以使用者在表單 input 輸入值只是在畫面上更新 input，input 的值並不是因為 React state 改變而更新的。
- 可以用 `ref` 來得到 input value

### Controlled Component
- input 的 value 被 React 控制。
- 通常在 `onChange` 加上 callback function 來改變這個元素的 value。如此一來，使用者在表單的 input 輸入值則 state 立即更新，而更新過後的 input value 也即時更新在表單元素上。

#### 用 controlled component 的好處
- 更方便用來驗證 input 的值，像是限定輸入值必須為數字或其他特定符號。
- 可設定 submit 按鈕預設為 disabled，直到所有 input value 都有符合格式的資料後，再讓按鈕可以被點擊。
