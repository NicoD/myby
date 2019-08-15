
import React from 'react';
import { List, Datagrid, TextField, EmailField, DateField, ShowButton, EditButton } from 'react-admin';

export const UserList = (props) => (
    <List {...props} title="Users"  perPage={ 2 }>
        <Datagrid>
            <TextField source="originId" label="ID"/>
            <EmailField source="email" label="Email" />
        </Datagrid>
    </List>
);
