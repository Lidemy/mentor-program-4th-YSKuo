import React, { useState } from 'react';
import styled from 'styled-components';
import { sendNewPost } from '../../WebAPI';
import { useHistory } from 'react-router-dom';

const ErrorMessage = styled.div`
  color: red;
`;

const Form = styled.form`
  width: 60%;
  margin: 0 auto;
  padding: 40px;
  display: flex;
  flex-direction: column;
  align-items: center;
`;

const Title = styled.div`
  display: flex;
  margin-bottom: 20px;
`;

const TitleInput = styled.input`
  width: 300px;
  margin-left: 20px;
`;

const Content = styled.div`
  display: flex;
  align-items: flex-start;
  margin-bottom: 20px;
`;

const ContentTextarea = styled.textarea`
  width: 300px;
  margin-left: 20px;
`;

const SubmitButton = styled.button``;

export default function CreateNewPostPage() {
  const [title, setTitle] = useState('');
  const [body, setBody] = useState('');
  const [errorMessage, setErrorMessage] = useState();
  const history = useHistory();

  const handleSubmit = (e) => {
    e.preventDefault();
    sendNewPost(title, body).then((data) => {
      if (data.ok === 0) {
        return setErrorMessage(data.message);
      }
      history.push('/');
    })
  }

  return (
    <Form onSubmit={handleSubmit}>
      <Title>
        標題:
        <TitleInput value={title} onChange={e => setTitle(e.target.value)} />
      </Title>
      <Content>
        內容:
        <ContentTextarea 
          rows={10}
          value={body} 
          onChange={e => setBody(e.target.value)}
        />
      </Content>
      <SubmitButton>發表</SubmitButton>
      {errorMessage && <ErrorMessage>{errorMessage}</ErrorMessage>}
    </Form>
  );
}
