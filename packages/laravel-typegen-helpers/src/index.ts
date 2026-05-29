// ─────────────────────────────────────────────
// Laravel Pagination
// ─────────────────────────────────────────────

export interface PaginationLinks {
    first: string;
    last: string;
    prev: string | null;
    next: string | null;
}

export interface PaginationMeta {
    current_page: number;
    from: number;
    last_page: number;
    path: string;
    per_page: number;
    to: number;
    total: number;
}

/** Matches the JSON shape of a Laravel `paginate()` response. */
export interface PaginatedResponse<T> {
    data: T[];
    links: PaginationLinks;
    meta: PaginationMeta;
}

/** Matches the shape of `simplePaginate()` — no total/last_page. */
export interface SimplePaginatedResponse<T> {
    data: T[];
    links: Pick<PaginationLinks, 'prev' | 'next'>;
}

// ─────────────────────────────────────────────
// Inertia.js Form Helpers
// ─────────────────────────────────────────────

/** Mirrors the Inertia `useForm()` return shape for typed forms. */
export interface InertiaForm<TData extends Record<string, unknown>> {
    data: TData;
    errors: Partial<Record<keyof TData, string>>;
    hasErrors: boolean;
    processing: boolean;
    progress: { percentage: number } | null;
    wasSuccessful: boolean;
    recentlySuccessful: boolean;
    isDirty: boolean;
    reset(...fields: (keyof TData)[]): void;
    clearErrors(...fields: (keyof TData)[]): void;
    setError(field: keyof TData, value: string): void;
    setError(errors: Partial<Record<keyof TData, string>>): void;
    transform(callback: (data: TData) => object): this;
    submit(method: string, url: string, options?: InertiaFormOptions): void;
    get(url: string, options?: InertiaFormOptions): void;
    post(url: string, options?: InertiaFormOptions): void;
    put(url: string, options?: InertiaFormOptions): void;
    patch(url: string, options?: InertiaFormOptions): void;
    delete(url: string, options?: InertiaFormOptions): void;
}

export interface InertiaFormOptions {
    preserveScroll?: boolean;
    preserveState?: boolean;
    onSuccess?: () => void;
    onError?: (errors: Record<string, string>) => void;
    onFinish?: () => void;
}

// ─────────────────────────────────────────────
// API Resource helpers
// ─────────────────────────────────────────────

/** Wraps a single `JsonResource` response envelope. */
export interface ApiResource<T> {
    data: T;
}

/** Wraps a `ResourceCollection` response envelope. */
export interface ApiResourceCollection<T> {
    data: T[];
}

// ─────────────────────────────────────────────
// Eloquent Relation helpers
// ─────────────────────────────────────────────

/**
 * Mirrors the `Relation<T>` helper emitted by laravel-typegen when
 * `relations.wrap_with_relation` is enabled.
 *
 * - `null`      → relation is known to be empty / deleted
 * - `undefined` → relation was not eager-loaded
 * - `T | T[]`   → relation was loaded
 */
export type Relation<T> = T | T[] | null | undefined;

/** Narrows a `Relation<T>` to its loaded (non-null, non-undefined) form. */
export type LoadedRelation<T> = T | T[];

// ─────────────────────────────────────────────
// Utility types
// ─────────────────────────────────────────────

/** Makes all properties of T optional recursively. */
export type DeepPartial<T> = {
    [P in keyof T]?: T[P] extends object ? DeepPartial<T[P]> : T[P];
};

/** Marks specific keys of T as required. */
export type RequireFields<T, K extends keyof T> = T & Required<Pick<T, K>>;

/** Extract the element type from an array. */
export type Unarray<T> = T extends (infer U)[] ? U : T;

/** A record keyed by the string values of an enum or union. */
export type EnumRecord<K extends string, V> = Record<K, V>;
