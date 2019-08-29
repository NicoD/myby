import React from 'react';
import { List, Datagrid, TextField, EmailField, ReferenceArrayField, SingleFieldList, ChipField, ReferenceField } from 'react-admin';

export const UserList = (props) => (
    <List {...props} title="Users"  perPage={ 10 }>
        <Datagrid>
            <TextField source="id" label="ID"/>
            <EmailField source="email" label="Email" />
            <ReferenceArrayField label="Role" source="roleObjects" reference="roles" linkType="show">
                <SingleFieldList>
                    <ChipField source="@id" />
                </SingleFieldList>
            </ReferenceArrayField>
            <ReferenceField label="UserProfile" source="userProfile" reference="user_profiles" linkType="show">
                <TextField source="@id" />
            </ReferenceField>
        </Datagrid>
    </List>
);
