## 程式碼

```javascript
for(var i=0; i<5; i++) {
  console.log('i: ' + i)
  setTimeout(() => {
    console.log(i)
  }, i * 1000)
}
```

---

## 結果

```
i: 0
i: 1
i: 2
i: 3
i: 4
5
5
5
5
5
```

---

## 解釋

### 執行主程式

將整個程式稱呼為 `main`，當它開始執行時排入 call stack

##### call stack
```javascript
main()
```

---
<br>

### 執行 main 內部程式碼

#### 執行 for 迴圈

將 for 迴圈排入 call stack

##### call stack
```javascript
for loop
main()
```

---

#### i = 0

`console.log('i: ' + i)` 排入 call stack

##### call stack
```javascript
console.log('i: ' + 0)
for loop
main()
```

`console.log('i: ' + 0)` 可直接執行，因此印出結果為

##### console
```
i: 0
```

執行完 `console.log('i: ' + 0)` 後，從 call stack 移除

##### call stack
```javascript
for loop
main()
```

接著執行下一行，將 `setTimeout(cb)` 放入 call stack 後

##### call stack
```javascript
setTimeout(cb)
for loop
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
for loop
main()
```

setTimeout 設定 `i * 1000` ms，此時 i 為 0 所以 timer 在 0ms 計時完畢，又因為 setTimeout 是非同步 callback function，所以 cb 會放到 callback queue

##### callback queue
```javascript
console.log(i)
```

i = 0 的內容執行完畢，i 值加一變為 1

---

#### i = 1

`console.log('i: ' + i)` 排入 call stack

##### call stack
```javascript
console.log('i: ' + 1)
for loop
main()
```

`console.log('i: ' + 1)` 可直接執行，因此印出結果為

##### console
```
i: 0
i: 1
```

執行完 `console.log('i: ' + 1)` 後，從 call stack 移除

##### call stack
```javascript
for loop
main()
```

接著執行下一行，將 `setTimeout(cb)` 放入 call stack 後

##### call stack
```javascript
setTimeout(cb)
for loop
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
for loop
main()
```

setTimeout 設定 `i * 1000` ms，此時 i 為 1 所以 timer 在 1000ms 計時完畢，又因為 setTimeout 是非同步 callback function，所以 cb 會在計時完畢時放到 callback queue

##### callback queue
```javascript
console.log(i)
console.log(i)
```

i = 1 的內容執行完畢，i 值加一變為 2

i = 2, 3, 4 時的狀況一樣，以下直接跳到 i = 5 時的情形開始推演

---

#### i = 5

i = 5 時迴圈結束，印出結果如下

##### console
```
i: 0
i: 1
i: 2
i: 3
i: 4
```

此時的 call stack 

##### call stack
```javascript
main()
```

又主程式只有迴圈，當迴圈結束時 `main()` 也結束了，所以從 call stack 移除

##### call stack
```javascript
```

---
<br>

### 處理 callback queue

此時 call stack 是空的，開始處理 callback queue 的任務

##### callback queue
```javascript
console.log(i)
console.log(i)
console.log(i)
console.log(i)
console.log(i)
```

因為此時 i 的值是 5，所以每個 `console.log(i)` 依序放入 call stack 執行，最後印出結果如下

##### console
```
i: 0
i: 1
i: 2
i: 3
i: 4
5
5
5
5
5
```
