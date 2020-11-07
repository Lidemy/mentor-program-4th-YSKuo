import styled from "styled-components";
import Header from './Header';
import { FormSubtitle, RequiredTag, FormInput, FormOption, FormDesc, FormSubmit, Warning } from './sub_components/FormSubComponents';
import React, { useState } from 'react';

const Form = styled.form`
  box-shadow: 1.8px 2.4px 5px 0 rgba(0, 0, 0, 0.3);
  background-color: white;
  max-width: 645px;
  margin: 0 auto;
  border-top: 8px solid #fad312;
  padding: 54px 40px 35px 40px;

  & h1 {
    font-size: 36px;
  }

  & h2 {
    font-size: 20px;
  }

  & p {
    font-size: 14px;
  }
`;

export default () => {
  const [info, setInfo] = useState({
    nickname: '',
    email: '',
    phone: '',
    type: '',
    referal: '',
    suggestion: '',
    hasEmpty: false
  });

  const handleInputChange = (e) => {
    const name = e.target.name;
    const value = e.target.value;

    setInfo({
      ...info,
      [name]: value
    })
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (
      !info['nickname'] ||
      !info['email'] ||
      !info['phone'] ||
      !info['type'] ||
      !info['referal']
    ) {
      setInfo({ ...info, hasEmpty: true })
      console.log('empty');
      return
    }
    console.log('success');
    setInfo({ ...info, hasEmpty: false })
    const keysToValues = Object.entries(info).filter((item) => item[0] !== "hasEmpty").map((value) => `${value[0]}: ${value[1]}`);
    const infoOnAlert = keysToValues.reduce((ac, cur) => `${ac}\n${cur}`);
    alert(infoOnAlert);
  };

  return (
    <Form onSubmit={handleSubmit}>
      <Header/>

      <div >
        <FormSubtitle>
          暱稱 <RequiredTag>*</RequiredTag> 
        </FormSubtitle>
        <FormInput>
          <input
            type="text"
            name="nickname"
            value={info['nickname']}
            onChange={handleInputChange}
          />
        </FormInput>
        {!info['hasEmpty'] || (!info['nickname'] && (
          <Warning>此欄為必填</Warning>
        ))}
      </div>

      <div>
        <FormSubtitle>
          電子郵件 <RequiredTag>*</RequiredTag> 
        </FormSubtitle>
        <FormInput>
          <input
            type="text"
            name="email"
            value={info['email']}
            onChange={handleInputChange}
          />
        </FormInput>
        {!info['hasEmpty'] || (!info['email'] && (
          <Warning>此欄為必填</Warning>
        ))}
      </div>

      <div>
        <FormSubtitle>
          手機號碼 <RequiredTag>*</RequiredTag> 
        </FormSubtitle>
        <FormInput>
          <input
            type="phone"
            name="phone"
            value={info['phone']}
            onChange={handleInputChange}
          />
        </FormInput>
        {!info['hasEmpty'] || (!info['phone'] && (
          <Warning>此欄為必填</Warning>
        ))}
      </div>

      <div>
        <FormSubtitle>
          報名類型 <RequiredTag>*</RequiredTag> 
        </FormSubtitle>
        <FormOption>
          <label>
            <input
              name="type"
              type="radio"
              value="躺在床上用想像力實作"
              onChange={handleInputChange}
            />躺在床上用想像力實作
          </label>
          <label>
            <input
              name="type"
              type="radio"
              value="趴在地上滑手機找現成的"
              onChange={handleInputChange}
            />趴在地上滑手機找現成的
          </label>
        </FormOption>
        {!info['hasEmpty'] || (!info['type'] && (
          <Warning>此欄為必填</Warning>
        ))}
      </div>

      <div>
        <FormSubtitle>
          怎麼知道這個活動的？<RequiredTag>*</RequiredTag>
        </FormSubtitle>
        <FormInput>
          <input
            type="text"
            name="referal"
            value={info['referal']}
            onChange={handleInputChange}
          />
        </FormInput>
        {!info['hasEmpty'] || (!info['referal'] && (
          <Warning>此欄為必填</Warning>
        ))}
      </div>

      <div>
        <FormSubtitle>其他</FormSubtitle>
        <FormDesc>對活動的一些建議</FormDesc>
        <FormInput>
          <input
            type="text"
            name="suggestion"
            value={info['suggestion']}
            onChange={handleInputChange}
          />
        </FormInput>
      </div>
      
      <div>
        <FormSubmit>提交</FormSubmit>
        <FormDesc>請勿透過表單送出您的密碼。</FormDesc>
      </div>
    </Form>
  )
};
