import React from 'react';
import { List, Datagrid, TextField, ShowButton } from 'react-admin';

export const RoleList = (props) => (
    <List {...props} title="Roles">
        <Datagrid>
            <TextField source="id" label="ID"/>
            <ShowButton />
        </Datagrid>
    </List>
);
