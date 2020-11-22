import React, { useState, useContext } from 'react';
import styled from 'styled-components';
import { signUp, getMe } from '../../WebAPI';
import { setAuthToken } from '../../utils';
import { useHistory } from 'react-router-dom';
import { AuthContext } from '../../contexts';

const ErrorMessage = styled.div`
  color: red;
`;

const Form = styled.form`
  width: 60%;
  margin: 0 auto;
  padding: 40px;
  text-align: center;
`;

export default function SignUpPage() {
  const { setUser } = useContext(AuthContext);
  const [nickname, setNickname] = useState('');
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [errorMessage, setErrorMessage] = useState();
  const history = useHistory();

  const handleSubmit = (e) => {
    setErrorMessage(null); // 先把錯誤訊息抹掉
    signUp(nickname, username, password).then((data) => {
      if (data.ok === 0) {
        return setErrorMessage(data.message)
      }
      setAuthToken(data.token); // 登入成功把 token 放到 localStorage

      getMe().then((response) => { // 驗證身份
        if (response.ok !== 1) {
          setAuthToken(null);
          return setErrorMessage(response.toString());
        }
        setUser(response.data); // 設定登入狀態
        history.push('/'); // 把頁面導向首頁
      });
    })
  }
  return (
    <Form onSubmit={handleSubmit}>
      <div>
        暱稱: 
        <input value={nickname} onChange={e => setNickname(e.target.value)} />
      </div>
      <div>
        帳號: 
        <input value={username} onChange={e => setUsername(e.target.value)} />
      </div>
      <div>
        密碼: 
        <input 
          type="password" 
          value={password} 
          onChange={e => setPassword(e.target.value)} 
        />
      </div>
      <button>註冊</button>
      {errorMessage && <ErrorMessage>{errorMessage}</ErrorMessage>}
    </Form>
  );
}
