// Import the `mount()` method from Vue Test Utils
import { mount } from "@vue/test-utils";
import VDataTable from "./index.vue";
import { describe, expect, test } from "vitest";

describe("test label button is same with props label", () => {
    test("display label button", () => {
        const wrapper = mount(VDataTable, {
            props: {
                heads: [
                    "Name",
                    "Branch",
                    "Designation",
                    "Email",
                    "Begin Contract",
                    "End Contract",
                    "Role",
                ],
            },
        });
        expect(wrapper.find("th").classes()).toStrictEqual([
            "px-4",
            "h-10",
            "whitespace-nowrap",
            "border-t",
            "border-b",
            "border-slate-200",
        ]);
    });
});
