## 程式碼

```javascript
console.log(1)
setTimeout(() => {
  console.log(2)
}, 0)
console.log(3)
setTimeout(() => {
  console.log(4)
}, 0)
console.log(5)
```

---

## 結果

##### console
```
1
3
5
2
4
```

---

## 解釋

依照規則，程式會按照先後順序執行，不過遇到非同步的 function 會另外處理

> 非同步的 callback function 會先被放到 callback queue，並且等到 call stack 為空時候才被 event loop 丟進去 call stack

以下按部就班說明流程

---
<br>

### 執行主程式

將整個程式稱呼為 `main`，當它開始執行時排入 call stack

##### call stack
```javascript
main()
```

---
<br>

### 執行 main 內部程式碼

#### 第一行
`console.log(1)` 不是非同步 callback function，直接排入 call stack

##### call stack
```javascript
console.log(1)
main()
```

`console.log(1)` 可直接執行，因此印出結果為

##### console
```
1
```

執行完 `console.log(1)` 後，從 call stack 移除

##### call stack
```javascript
main()
```

---

#### 第二行

第二行 `setTimeout(cb)` 放入 call stack 後

##### call stack
```javascript
setTimeout(cb)
main()
```

接著執行 `setTimeout(cb)` 呼叫 Web API 來計時

##### webapis
```
timer() // cb
```

執行完 `setTimeout(cb)` 後，從 call stack 移除

##### call stack
```javascript
main()
```

setTimeout 設定 0ms，所以 Web API 的 timer 在 0ms 計時完畢，此時因為 setTimeout 是非同步 callback function，所以 cb 會放到 callback queue

##### callback queue
```javascript
cb(() => {console.log(2)})
```

---

#### 第五行

不是非同步 callback function，因此 `console.log(3)` 直接排入 call stack

##### call stack
```javascript
console.log(3)
main()
```

`console.log(3)` 可直接執行，因此印出結果為

##### console
```
1
3
```

執行完 `console.log(3)` 後，從 call stack 移除

##### call stack
```javascript
main()
```

---

#### 第六行

第六行的 `setTimeout(cb)` 放入 call stack 後

##### call stack
```javascript
setTimeout(cb)
main()
```

接著執行 `setTimeout(cb)` 呼叫 Web API 來計時

##### webapis
```
timer() // cb
```

執行完 `setTimeout(cb)` 後，從 call stack 移除

##### call stack
```javascript
main()
```

因為是非同步 callback function，所以 cb 會放到 callback queue

##### callback queue
```javascript
cb(() => {console.log(2)})
cb(() => {console.log(4)})
```

---

#### 第九行

不是非同步 callback function，因此 `console.log(5)` 直接排入 call stack

##### call stack
```javascript
console.log(5)
main()
```

`console.log(5)` 可直接執行，因此印出結果為

##### console
```
1
3
5
```

執行完 `console.log(5)` 後，從 call stack 移除

##### call stack
```javascript
main()
```

---

#### main 結束
因為 `main()` 的程式已經執行完畢，所以從 call stack 移除

##### call stack
```javascript
```

---
<br>

### 處理 callback queue

此時 call stack 是空的，開始處理 callback queue 的任務

##### callback queue
```javascript
cb(() => {console.log(2)})
cb(() => {console.log(4)})
```

---

#### 處理 `cb(() => {console.log(2)})`

按照 callback queue 的順序，首先處理 `cb(() => {console.log(2)})`

將 callback queue 的任務依序丟入 call stack 處理

##### call stack
```javascript
cb(() => {console.log(2)})
```

執行 cb 內的程式碼，將 `console.log(2)` 排入 call stack

##### call stack
```javascript
console.log(2)
cb(() => {console.log(2)})
```

`console.log(2)` 可直接執行，因此印出結果為

##### console
```
1
3
5
2
```

執行完 `console.log(2)` 後，從 call stack 移除

##### call stack
```javascript
cb(() => {console.log(2)})
```

執行完 `cb(() => {console.log(2)})`，從 call stack 移除

##### call stack
```javascript
```

此時 call stack 是空的，再次處理 callback queue 的任務

##### callback queue
```javascript
cb(() => {console.log(4)})
```

---

#### 處理 `cb(() => {console.log(4)})`

將 callback queue 的任務依序丟入 call stack 處理

##### call stack
```javascript
cb(() => {console.log(4)})
```

執行 cb 內的程式碼，將 `console.log(4)` 排入 call stack

##### call stack
```javascript
console.log(4)
cb(() => {console.log(4)})
```

`console.log(4)` 可直接執行，因此印出結果為

##### console
```
1
3
5
2
4
```

執行完 `console.log(4)` 後，從 call stack 移除

##### call stack
```javascript
cb(() => {console.log(4)})
```

執行完 `cb(() => {console.log(4)})`，從 call stack 移除

##### call stack
```javascript
```

call stack 和 callback queue 都空了，整個程式結束，最終印出結果如下。

##### console
```
1
3
5
2
4
```
