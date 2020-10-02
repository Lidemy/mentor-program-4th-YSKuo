## 程式碼

```javascript
var a = 1
function fn(){
  console.log(a)
  var a = 5
  console.log(a)
  a++
  var a
  fn2()
  console.log(a)
  function fn2(){
    console.log(a)
    a = 20
    b = 100
  }
}
fn()
console.log(a)
a = 10
console.log(a)
console.log(b)
```

---
<br>

## 結果

##### console
```
undefined
5
6
20
1
10
100
```

---
<br>

## 解釋

### 進入 Global EC

#### Global EC 初始化

##### 運作模型
```javascript
globalEC: {
  VO: {
    a: undefined,
    fn: function
  },
  scoepeChain: globalEC.VO
}
```

---

#### 執行 global 程式碼

開始依照順序執行程式碼，執行到 `var a = 1` 及 `function fn() {...}` 時，運作模型如下

##### 運作模型
```javascript
globalEC: {
  VO: {
    a: 1, // 更改值
    fn: function
  },
  scoepeChain: globalEC.VO
}

fn.[[Scope]] = globalEC.scopeChain // 新增
```

---
<br>

### 進入 fn EC

執行到 `fn()` 後先進行初始化

#### 建立 fn EC 和 AO

##### 運作模型
```javascript
fnEC: {
  AO: {
    a: undefined,
    fn2: function
  },
  scopeChain: [fnEC.AO, fnEC.[[Scope]]]
            = [fnEC.AO, globalEC.VO]
}

globalEC: {
  VO: {
    a: 1,
    fn: function
  },
  scoepeChain: globalEC.VO
}

fn.[[Scope]] = globalEC.scopeChain
```

---

#### 執行 fn 程式碼

當執行到 `console.log(a)`，此時在 fn 的 scope，而 fn 內的 a 值為 `undefined`

##### console
```
undefined
```

執行到 `var a = 5` 時

##### 運作模型
```javascript
fnEC: {
  AO: {
    a: 5, // 更改值
    fn2: function
  },
  scopeChain: [fnEC.AO, globalEC.VO]
}

globalEC: {
  VO: {
    a: 1,
    fn: function
  },
  scoepeChain: globalEC.VO
}

fn2.[[scope]] = fn.scopeChain
```

執行到 `console.log(a)`，此時 fn 的 a 值為 `5`，因此印出結果如下

##### console
```
undefined
5
```

執行完 `a++` 這行，此時 a 值為 `6`

##### 運作模型
```javascript
fnEC: {
  AO: {
    a: 6, // 更改值
    fn2: function
  },
  scopeChain: [fnEC.AO, globalEC.VO]
}

globalEC: {
  VO: {
    a: 1,
    fn: function
  },
  scoepeChain: globalEC.VO
}

fn2.[[scope]] = fn.scopeChain
```

執行到 `var a`，因為 a 已經定義了，即使這邊再次定義也沒任何影響

接著執行 `fn2()`

---
<br>

### 進入 fn2 EC

#### 建立 fn2 EC 和 AO

##### 運作模型
```javascript
fn2EC: {
  AO: {},
  scopeChain: [fn2.AO, fn2.[[scope]]]
            = [fn2.AO, fnEC.AO, globalEC.VO]
}

fnEC: {
  AO: {
    a: 6,
    fn2: function
  },
  scopeChain: [fnEC.AO, globalEC.VO]
}

globalEC: {
  VO: {
    a: 1,
    fn: function
  },
  scoepeChain: globalEC.VO
}

fn2.[[scope]] = fn.scopeChain
```

---

#### 執行 fn2 程式碼

執行 `console.log(a)`，此時 fn2 EC 的 AO 沒有 a，因此往上一層找並在 fnEC 找到 a 的值為 6

##### console
```
undefined
5
6
```

執行 `a = 20`， fn2 EC 的 AO 沒有 a，因此改變上一層 fnEC 的 a 值

##### 運作模型
```javascript
fn2EC: {
  AO: {},
  scopeChain: [fn2.AO, fnEC.AO, globalEC.VO]
}

fnEC: {
  AO: {
    a: 20, // 更改值
    fn2: function
  },
  scopeChain: [fnEC.AO, globalEC.VO]
}

globalEC: {
  VO: {
    a: 1,
    fn: function
  },
  scoepeChain: globalEC.VO
}
```

執行 `b = 100`，在 fn2.AO, fnEC.AO, globalEC.VO 都沒有定義 b，如果在 `use strict` 模式，則會出現 `ReferenceError: b is not defined` 的訊息

這邊假設在一般模式，則 globalEC 會在 VO 加入 b 並設定值為 100

##### 運作模型
```javascript
fn2EC: {
  AO: {},
  scopeChain: [fn2.AO, fnEC.AO, globalEC.VO]
}

fnEC: {
  AO: {
    a: 20,
    fn2: function
  },
  scopeChain: [fnEC.AO, globalEC.VO]
}

globalEC: {
  VO: {
    a: 1,
    b: 100
    fn: function
  },
  scoepeChain: globalEC.VO
}
```

執行完 fn2 的程式，離開 fn2 EC 並回到 fn EC 

---
<br>

### 執行 fn 程式碼

執行完 fn2()，離開 fn2 的 EC 並回到 fn 的 EC，因為沒有其他 EC 用到 fn2 的 AO 內容因此 fn2EC 消失

##### 運作模型
```javascript
fnEC: {
  AO: {
    a: 20,
    fn2: function
  },
  scopeChain: [fnEC.AO, globalEC.VO]
}

globalEC: {
  VO: {
    a: 1,
    b: 100
    fn: function
  },
  scoepeChain: globalEC.VO
}
```

接著，繼續執行下一條 `console.log(a)`，此時 fn 的 a 值為 20

##### console
```
undefined
5
6
20
```

---
<br>

### 執行 global 程式碼

fn 的程式碼執行完畢，離開 fn 的 EC 並回到 global 的 EC，因為沒有其他 EC 用到 fn 的 AO 內容因此 fnEC 消失

##### 運作模型
```javascript
globalEC: {
  VO: {
    a: 1,
    b: 100
    fn: function
  },
  scoepeChain: globalEC.VO
}
```

繼續執行下一條程式碼 `console.log(a)`，此時 global 的 a 值為 1

##### console
```
undefined
5
6
20
1
```

執行 `a = 10`

##### 運作模型
```javascript
globalEC: {
  VO: {
    a: 10, // 更新值
    b: 100
    fn: function
  },
  scoepeChain: globalEC.VO
}
```

繼續執行下一條程式碼 `console.log(a)`，此時 global 的 a 值為 10

##### console
```
undefined
5
6
20
1
10
```

繼續執行下一條程式碼 `console.log(b)`，此時 global 的 b 值為 100

##### console
```
undefined
5
6
20
1
10
100
```

程式執行完畢